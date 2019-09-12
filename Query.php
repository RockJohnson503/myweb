<?php

namespace app\common\server;

use think\Db;
use think\helper\Str;

// 查询一对多的数据
class Query
{
    protected $parse_field = [];
    protected $group_field = '';
    protected $fields = '';
    protected $connection;
    protected $prefix = '';

    public function __construct()
    {
        $this->connection = Db::connect([], true);
        $this->prefix = $this->connection->getConfig('prefix');
    }

    /*
    传入数据
    参数格式: [要查询的字段, 别名(数组的key), 要查询的表, 查询的条件语句(没有条件可以省略不写), 联表(可以省略不写)];
    */
    public function with($data){
        if(is_string($data[1])){
            $this->gen_sql($data[0], $data[1], $data[2], $data[3], $data[4]);
        }else{
            foreach ($data as $item){
                $this->gen_sql($item[0], $item[1], $item[2], $item[3], $item[4]);
            }
        }

        return $this;
    }

    /*
    解析查询的数据
    参数格式: 模型层, 查询的方法名(字符串), 被调用方法的参数(传入的参数如果是字段参数就用字符串fields代替);
    */
    public function parse($model, $func, $data){
        // 处理参数
        $fields = $this->parse_field;
        foreach ($data as $key => $value){
            if ($value == 'fields'){
                $data[$key] = $this->fields.', '.$this->group_field;
            }
        }

        // 获取数据
        $lst = call_user_func_array([$model, $func], $data);
        if(!$lst){
            return [];
        }

        $flag = count($lst) == count($lst, 1);
        foreach ($fields as $i => $field){
            if($flag){
                $lst[$field] = $this->parse_detail($lst[$field]);
            }else{
                foreach ($lst as $key => $item){
                    $lst[$key][$field] = $this->parse_detail($item[$field]);
                }
            }
            unset($this->parse_field[$i]);
        }
        return $lst;
    }

    // 追加字段
    public function append($field){
        $this->fields .= $this->append_str($field, $this->fields);

        return $this;
    }

    public function append_str($field, $fields){
        $trim_field = trim($field);
        $new_field = ($fields ? ($trim_field[strlen($trim_field) - 1] == ',' ? ' ' : ', ') : '').$trim_field;

        return $new_field;
    }

    // 生成sql语句
    public function gen_sql($field, $as, $table, $con, $join){
        // 处理字段
        $content = '';
        if(is_string($field)){
            $field = $this->trim(explode(',', $field));
        }
        foreach ($field as $key => $item){
            $content .= ($key == 0 ? '' : ', ').($key == 0 ? '\'' : '\',').$item.'=\', '.$item;
        }

        // 处理条件语句
        $where = $con ? ' where '.$con : '';

        // 处理数据库
        $table = $this->add_prefix($table);

        // 处理join
        $join = $join ? $this->handle_join($join) : '';

        // 储存数据
        $this->parse_field[] = $as;

        // 拼接字段
        $this->group_field .= $this->append_str('(select group_concat('.$content.' separator \';\') from '.$table.$join.$where.') as '.$as, $this->group_field);
    }

    // 处理join
    public function handle_join($join){
        $new_join = '';
        if(count($join) == count($join, 1)){
            $new_join = $join ? (' '.($join[2] ? trim($join[2]) : 'inner').' join '.$this->add_prefix(trim($join[0])).' on '.trim($join[1])) : '';
        }else{
            foreach ($join as $item){
                $new_join .= ' '.($item[2] ? trim($item[2]) : 'inner').' join '.$this->add_prefix(trim($item[0])).' on '.trim($item[1]);
            }
        }
        return $new_join;
    }

    // 添加前缀
    public function add_prefix($table){
        return strstr($table, $this->prefix) ?: $this->prefix.$table;
    }

    // 解析的细节
    public function parse_detail($field){
        $arr = explode(';', $field);
        foreach ($arr as $key => $item){
            $item = explode(',', $item);
            foreach ($item as $k => $i){
                $i = explode('=', $i);
                $item[$i[0]] = $i[1];
                unset($item[$k]);
            }
            $arr[$key] = $item;
        }
        return $arr;
    }

    // 去空格
    public function trim($lst){
        foreach ($lst as $key => $item){
            $lst[$key] = trim($item);
        }
        return $lst;
    }
}
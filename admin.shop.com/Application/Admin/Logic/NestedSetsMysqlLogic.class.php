<?php
namespace Admin\Logic;
//use Admin\Logic\DbMysql;

class NestedSetsMysqlLogic implements DbMysql{

    /**
     * DB connect
     *
     * @access public
     *
     * @return resource connection link
     */
    public function connect()
    {
        // TODO: Implement connect() method.
        echo __METHOD__."<br/>";
        dump(func_get_args());
        echo "<hr/>";
    }

    /**
     * Disconnect from DB
     *
     * @access public
     *
     * @return viod
     */
    public function disconnect()
    {
        // TODO: Implement disconnect() method.
        echo __METHOD__."<br/>";
        dump(func_get_args());
        echo "<hr/>";
    }

    /**
     * Free result
     *
     * @access public
     * @param resource $result query resourse
     *
     * @return viod
     */
    public function free($result)
    {
        // TODO: Implement free() method.
        echo __METHOD__."<br/>";
        dump(func_get_args());
        echo "<hr/>";
    }

    /**
     * Execute simple query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return resource|bool query result
     */
    public function query($sql, array $args = array())
    {
        // 获取参数
        $params = func_get_args();
        // 获取原来sql
        $sql = array_shift($params);
        // 将sql根据替换字段拆分成数组
        $sqls = preg_split('/\?[FTN]/',$sql);
        // 去掉最后一个空字串
        array_pop($sqls);
        $sql = '';
        // 拼接sql
        foreach($sqls as $k=>$v){
            $sql.=$v.$params[$k];
        }
//        dump($sql);exit;
        // 执行sql
         return M()->execute($sql);

    }

    /**
     * Insert query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false last insert id
     */
    public function insert($sql, array $args = array())
    {
        // 获取参数
        $params = func_get_args();
//        dump($params);
        // 获取原来sql
        $sql = array_shift($params);
        // 将sql根据替换字段拆分成数组
        $sql = preg_replace('/\?[T]/',$params[0] , $sql);

        // 拼接保存数据部分的 sql
        $str = '';
        // 拼接sql
        foreach($params[1] as $k=>$v){
            $str .= '`'.$k.'`="'.$v.'",';
        }
        // 去掉最后的逗号
        $str = rtrim($str,',');
        // 拼接整个sql
        $sql = preg_replace('/\?%/',$str , $sql);
        // 执行sql
        $res = M()->execute($sql);
        if($res){
            return M()->getLastInsID();
        }else{
            return false;
        }
    }

    /**
     * Update query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false affected rows
     */
    public function update($sql, array $args = array())
    {
        // TODO: Implement update() method.
        echo __METHOD__."<br/>";
        dump(func_get_args());
        echo "<hr/>";
    }

    /**
     * Get all query result rows as associated array
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAll($sql, array $args = array())
    {
        // TODO: Implement getAll() method.
        echo __METHOD__."<br/>";
        dump(func_get_args());
        echo "<hr/>";
    }

    /**
     * Get all query result rows as associated array with first field as row key
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAssoc($sql, array $args = array())
    {
        // TODO: Implement getAssoc() method.
        echo __METHOD__."<br/>";
        dump(func_get_args());
        echo "<hr/>";
    }

    /**
     * Get only first row from query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array
     */
    public function getRow($sql, array $args = array())
    {

        // 获取初始sql
        $params = func_get_args();
        $sql = array_shift($params);
        // 根据每个替换字段 将sql拆分成数组
        $sqls = preg_split('/\?[FTN]/',$sql);
        // 删除最后一个空字符串
        array_pop($sqls);
        $sql = '';
        foreach($sqls as $k=>$v){
            $sql.= $v.$params[$k];
        }
        // 查询父节点数据
        $rows = M()->query($sql);
//        dump(array_shift($rows));exit;
        return array_shift($rows);

    }

    /**
     * Get first column of query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array one level data array
     */
    public function getCol($sql, array $args = array())
    {
        // TODO: Implement getCol() method.
        echo __METHOD__."<br/>";
        dump(func_get_args());
        echo "<hr/>";
    }

    /**
     * Get one first field value from query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return string field value
     */
    public function getOne($sql, array $args = array())
    {
        // TODO: Implement getOne() method.
        echo __METHOD__."<br/>";
        dump(func_get_args());
        echo "<hr/>";
    }
}
<?php
/*
 * class pub
 */

class pub  {
    var $db;
    var $table_page_manager;
    var $table_components;
    
    function pub(){
        $this->db=APP::ADP('db');
        $this->table_page_manager=$this->db->getTable(T_PAGE_MANAGER);
        $this->table_components=$this->db->getTable(T_COMPONENTS);
    }
    /**
     * 返回我wap版本广场首页第一个推荐组数据
     *
     *@return unknow
    */
    function getFirstLineTitle() {
        $sqlFormat="select p.id,p.page_id,p.component_id,p.title,p.param from %s p left join %s c on c.component_id=p.component_id where  page_id=1 and position=1 and type=2 order by sort_num limit 0,1;";
        $sql=sprintf($sqlFormat,$this->table_page_manager,$this->table_components);
        return RST($this->db->query($sql));
        
    }
    
    
    
}
?>
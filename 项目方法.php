<?php
/**
 * // 返回所需列表数据
 * @param $data    后台传过来的数据
 * @param $field_id    控件表单值
 * @param $field_name  控件文本值
 * @param $name    下拉菜单的名字
 */
function arr2select($data,$field_id,$field_name,$name,$selected=''){
    $html = '<select name="'.$name.'">';
    $html .= '<option value="">请选择...</option>';
    // 拼接每一个下拉菜单
    foreach($data as $row){
        if(empty($selected)){
            $html .= '<option value="'.$row[$field_id].'">'.$row[$field_name].'</option>';
        }else{
            if($selected == $row[$field_id]){
                $html .= '<option  value="' . $row[$field_id] . '"selected="selected">'.$row[$field_name].'</option>';

            }else{
                $html .= '<option value="' . $row[$field_id] . '">'.$row[$field_name].'</option>';

            }
        }


    }
    return $html .= '</select>';
}



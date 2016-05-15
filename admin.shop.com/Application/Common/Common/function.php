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

            if($selected == $row[$field_id]){
                $html .= '<option  value="' . $row[$field_id] . '"selected="selected">'.$row[$field_name].'</option>';

            }else{
                $html .= '<option value="' . $row[$field_id] . '">'.$row[$field_name].'</option>';

            }



    }
    return $html .= '</select>';
}

/**
 * 展示商品状态数据
 * @param $data
 * @param $field_id
 * @param $field_name
 * @param $name
 * @param string $selected
 * @return string
 */
function onearr2select($data,$name,$selected=''){
    $html = '<select name="'.$name.'">';
    $html .= '<option value="">请选择...</option>';
    // 拼接每一个下拉菜单
//    dump($selected);
    foreach($data as $k=>$v){
        $k = (string)$k;
            if($selected === $k){
                $html .= '<option  value="' . $k . '"selected="selected">'.$v.'</option>';

            }else{
                $html .= '<option value="' . $k . '">'.$v.'</option>';

            }
    }
    return $html .= '</select>';
}
<?php
function generate_list($array, $sel, $parent = '', $level = 1,$prod){
	$level++;
    foreach ($array as $value)
    {
      $has_children=false;

      $checked = '';
      if (isset($prod) && $prod['Product']['category_id'] == $value['Category']['id']) {
        $checked = 'checked';
      }

      //if ($value['Category']['parent_id']==$parent)
      //{
        $li = '<li><div>';
         
        $li .= ($level != 4)? '<i class=" gi gi-circle_plus treeaction" data-child="level'.($level + 1).'"></i>' : '';
        $li .= '<span>';
        $li .= $value['Category']['name'];
        $li .= '</span>';
        $li .= '<div class="tools">';
        if($sel){
          $li .= '<input class="category_radio" type="radio" name="category_id" value="'.$value['Category']['id'].'" id="category_radio_'.$value['Category']['id'].'" '.$checked.'>';
        }else{
          $li .= '<a href="categories/edit/'.$value['Category']['id'].'" class="btn btn-small btn-warning"><i class="icon-cog"></i> Editar</a>';
          $li .= '<a class="btn btn-small btn-danger deletebutton" 
                    data-id="'.$value['Category']['id'].'"
                    data-url-back="'.Router::url( "/", true ).'categories/index"
                    data-delurl="'.Router::url( "/", true ).'categories/delete"
                    data-msg="'.__('¿Eliminar categoria?').'"
                    ><i class="icon-remove"></i> Borrar</a>';
          $li .= '<a href="products/bycategory/'.$value['Category']['id'].'" class="btn btn-small btn-primary"><i class="icon-reorder"></i> Productos</a>';
        }
        $li .= '</div>';
        $li .= '<br class="clr">';
        $li .= '</div>';
        echo $li;

        //if ($has_children==false){
          //$has_children=true;
          //echo '<ul class="level'.$level.'">';
        //}

        //generate_list($array,$sel,$value['Category']['id'],$level);

        //if ($has_children==true) echo '</ul>';
        echo '</li>';
      //}

    }
}
?>
<div class="treeview">
  <ul class="level1">
    <?php 
      $prod = (isset($prod)) ? $prod : null;
      echo generate_list($cats, $sel, 12, 1, $prod); 
    ?> 
  </ul>
</div>
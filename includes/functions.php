<?php



function getTimeTable($train_no){
    $t_no = file_get_html('https://www.trainman.in/train/'.$train_no.'');
    $train_schedule_data = array('route'=>[]);

    if(empty($t_no->find('div.card-body h1#h1', 0)) 
        && empty($t_no->find('div.col-5.p-0.col-sm-4', 0))
        &&  empty($t_no->find('div.col-1.p-0.col-sm-4', 0))
        && empty($t_no->find('div.col-5.p-0.col-sm-4', 1))
     )
    {
        $train_schedule_data['error'] =  'No Train Exists for this number '.$train_no;
    }else{
        $train_schedule_data['train_name'] = $t_no->find('div.card-body h1#h1', 0)->innertext;
        $train_schedule_data['runs_on'] = $t_no->find('div.col-5.p-0.col-sm-4', 0)->innertext;
        $train_schedule_data['pantry_car'] = $t_no->find('div.col-1.p-0.col-sm-4', 0)->plaintext;
        $train_schedule_data['class'] = $t_no->find('div.col-5.p-0.col-sm-4', 1)->innertext;
    }



    // Station Name 
    $i = 0;
    foreach($t_no->find('table tr td.text-truncate strong') as $element){
        if(empty($element->innertext) 
            && empty($t_no->find('table tr.table_row'.$i.' td',2))
            && empty($t_no->find('table tr.table_row'.$i.' td',3))
            && empty($t_no->find('table tr.table_row'.$i.' td',4))
            && empty($t_no->find('table tr.table_row'.$i.' td',5))
            && empty($t_no->find('table tr.table_row'.$i.' td',6))
        )
        {
          continue; //will skip <a> without href
        }else{
            $train_schedule_data['route'][$i]['stn_name'] = $element->innertext;
            $t_no->find('table tr', $i+1)->addClass('table_row'.$i);;
            $train_schedule_data['route'][$i]['start'] = $t_no->find('table tr.table_row'.$i.' td',2)->innertext;
            $train_schedule_data['route'][$i]['halt'] = $t_no->find('table tr.table_row'.$i.' td',3)->innertext;
            $train_schedule_data['route'][$i]['day_count'] = $t_no->find('table tr.table_row'.$i.' td',4)->innertext;
            $train_schedule_data['route'][$i]['distance_covered'] = $t_no->find('table tr.table_row'.$i.' td',5)->innertext;
            $train_schedule_data['route'][$i]['platform'] = $t_no->find('table tr.table_row'.$i.' td',6)->innertext;
            $i++;
        }
    }

    // Station Code
    $j = 0;
    foreach($t_no->find('table tr td.text-truncate div u') as $element){
        $train_schedule_data['route'][$j]['stn_code'] = $element->innertext;
        $j++;
    }

    return $train_schedule_data;

}
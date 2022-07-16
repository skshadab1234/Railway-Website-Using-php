<?php

if(isset($_POST['train_no'])){
    $train_no = $_POST['train_no'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://irctc1.p.rapidapi.com/api/v1/searchTrain?query=".$train_no."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: irctc1.p.rapidapi.com",
            "X-RapidAPI-Key: 1108bf426emsh0242dc4a47b9377p1c4b1cjsnfaa6e2a6ca98"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $result = json_decode($response, true);

    // echo "<pre>";
    // print_r($result);

    if(empty($result['data'])) {
        echo "No Train Found";
    }else{
        ?>
        <h4 class="mt-5">Search Results</h4>
            <?php
            foreach($result['data'] as $key => $value){
                
            ?>
                <div class="card border col-sm-3 m-3 p-2">
                    <h5 class="p-2"><?= $value['train_number'] ?></h5>
                    <p class="p-2 pt-0 fw-bold"><?=  $value['train_name'] ?></p>
                    <a href="#" style="text-decoration: none;font-size: 18px;text-align: center;color: blue;" onclick="getschedule(<?= $value['train_number'] ?>)">View Schedule</a>
                </div>

            <?php
            
        }

        ?>
        
        <script>
            function getschedule(t_no) {
                $("#train_no").val(t_no);
                $("#train_schedule_submit").submit();
            }
            // var val = $("#train_no_input").val();
            // $("#train_no"+val).click(() => {
            //     console.log(val);
            // })
        </script>
        <?php
         
    }
}
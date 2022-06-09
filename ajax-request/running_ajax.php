<?php
include "../includes/functions.php";



if(isset($_POST['train_no'])) {
	// $train_no = 11079;
	// $start_day = 0;
	$train_no = $_POST['train_no'];
	$start_day = $_POST['start_day'];
	$curl = curl_init();

	curl_setopt_array($curl, [
		CURLOPT_URL => "https://irctc1.p.rapidapi.com/api/v1/liveTrainStatus?trainNo=".$train_no."&startDay=".$start_day."",
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
	$result = json_decode($response, true);
	$err = curl_error($curl);

	curl_close($curl);

	// echo "<pre>";
	// print_r($response);
	// die();
	
	$running_data  = $result['data'];

	$previous_stn_arr = $running_data['previous_stations'];
	$upcoming_stations_arr = $running_data['upcoming_stations'];
	

	foreach ($previous_stn_arr as $prev_key => $prev_val) {
		// echo ($prev_val['station_name']);
		// echo "<br>";
		$station_name = $prev_val['station_name'];
		$st_code = $prev_val['station_code'];
		$plat_no =  "Platform : #".$prev_val['platform_number'];
		$halt = "Stop : ".$prev_val['halt']."min";
		$arrival_delay = $prev_val['arrival_delay'];

		$eta = "Arr ".$prev_val['eta'];
		$etd =  "Dept ".$prev_val['etd'];

		$sta = "Schd ".$prev_val['sta'];
		$std = '';
		if(isset($prev_val['std'])){
			$std = "Schd ".$prev_val['std'];
		}

		
		if($prev_val['station_name'] == '' ) {
			$station_name = $running_data['current_station_name'];
			$st_code = $running_data['current_station_code'];
			$plat_no = '';
			$halt = '';

			$eta = "";
			$etd =  "";

			$sta = "";
			$std = '';

			
		}

		
		// ESTIMATE TIME IS GREATER THAN STANDARD TIME THAN CHANGE COLOR TO RED
		$make_red = 'text-primary';
		$count_day = date("Y-m-d", strtotime('+'.$prev_val['a_day'].' day', strtotime($running_data['train_start_date'])));
		if (strtotime($count_day.' '.$prev_val['eta']) > strtotime($count_day.' '.$prev_val['sta']) || (strtotime($count_day.' '.$upcoming_val['eta']) - strtotime($count_day.' '.$upcoming_val['sta'])) < 0)
		{	
			$make_red = 'text-danger';
		}

		?>
		<style>
			.time_struc<?= $st_code ?>:before{
				background-color: #26b5a9;
			}
		</style>
		<div class="container text-center mt-4">
			<ul class="timeline time_struc<?= $st_code ?> text-center container">    
				<li class="timeline-inverted">
					<div class="timeline-badge arrived"></div>
						<div class="" >
								<div class="row" style="width:90%;margin-left:10%;border: 1px solid #ddd;padding: 20px 0">
									<!-- Train NAME AND ALL  -->
									<div class="col-12 col-md-3">
										<h5><?= $st_code ?> - <?= $station_name ?></h5>
									</div>

									<!-- Platform and halt time  -->
									<div class="col-12 col-md-3">
										<h5 class="fs-6"> <strong><?= $plat_no ?></strong> | <strong><?= $halt ?></strong></h5>
									</div>

									<!-- Arrival Dept  -->
									<div class="col-12 col-md-4">
										<div class="row">
											<!-- Arrival  -->
											<div class="col-6">
												<h5 class="<?= $make_red ?>"> <?= $eta  ?></h5>
												<p> <?= $sta ?></p>
											</div>
											<!-- Departure time -->
											<div class="col-6">
												<h5 class="<?= $make_red ?>"> <?= $etd  ?></h5>
												<p> <?= $std ?></p>
											</div>
										</div>
									</div>

									<!-- Delay  -->
									<div class="col-12 col-md-2">
										<?php 
											$delay_time =  $arrival_delay." min";
											if($arrival_delay > 60) {
										       $delay_time = intdiv($arrival_delay, 60).' hrs '. ($arrival_delay % 60) ." min";
											}

											if($delay_time > 0) {
												echo "<h5 class='text-danger'>".$delay_time."</h5><p class='text-danger'>Late</p>";
											}else{
												echo "<h5 class='text-success'>No Delay</h5>";
											}
										?>
									</div>
								</div>
						</div>
				</li>
			</ul>
		</div>
		<?php
		
	}


	foreach ($upcoming_stations_arr as $upcoming_key => $upcoming_val) {
		// echo ($upcoming_val['station_name']);
		// echo "<br>";
		$station_name = $upcoming_val['station_name'];
		$st_code = $upcoming_val['station_code'];
		$plat_no =  "Platform #".$upcoming_val['platform_number'];
		$halt = "Stop :".$upcoming_val['halt']."min";
		$arrival_delay = $upcoming_val['arrival_delay'];

		$eta = "Arr ".$upcoming_val['eta'];
		$etd =  "Dept ".$upcoming_val['etd'];

		$sta = "Schd ".$upcoming_val['sta'];
		$std = '';
		if(isset($upcoming_val['std'])){
			$std = "Schd ".$upcoming_val['std'];
		}

		
		if($upcoming_val['station_name'] == '' ) {
			$station_name = $running_data['current_station_name'];
			$st_code = $running_data['current_station_code'];
			$plat_no = '';
			$halt = '';

			$eta = "";
			$etd =  "";

			$sta = "";
			$std = '';

			
		}

		
		// ESTIMATE TIME IS GREATER THAN STANDARD TIME THAN CHANGE COLOR TO RED
		$make_red = 'text-primary';
		$count_day = date("Y-m-d", strtotime('+'.$upcoming_val['a_day'].' day', strtotime($running_data['train_start_date'])));
		if (strtotime($count_day.' '.$upcoming_val['eta']) > strtotime($count_day.' '.$upcoming_val['sta']) || (strtotime($count_day.' '.$upcoming_val['eta']) - strtotime($count_day.' '.$upcoming_val['sta'])) < 0)
		{	
			$make_red = 'text-danger';
		}

		?>
		<div class="container text-center mt-4">
			<ul class="timeline text-center container">    
				<li class="timeline-inverted">
					<div class="timeline-badge "><?=  $upcoming_key + 1 ?></div>
						<div class="" >
								<div class="row" style="width:90%;margin-left:10%;border: 1px solid #ddd;padding: 20px 0">
									<!-- Train NAME AND ALL  -->
									<div class="col-12 col-md-3">
										<h5><?= $st_code ?> - <?= $station_name ?></h5>
									</div>

									<!-- Platform and halt time  -->
									<div class="col-12 col-md-3">
										<h5 class="fs-6"> <strong><?= $plat_no ?></strong> | <strong><?= $halt ?></strong></h5>
									</div>

									<!-- Arrival Dept  -->
									<div class="col-12 col-md-4">
										<div class="row">
											<!-- Arrival  -->
											<div class="col-6">
												<h5 class="<?= $make_red ?>"> <?= $eta  ?></h5>
												<p> <?= $sta ?></p>
											</div>
											<!-- Departure time -->
											<div class="col-6">
												<h5 class="<?= $make_red ?>"> <?= $etd  ?></h5>
												<p> <?= $std ?></p>
											</div>
										</div>
									</div>

									<!-- Delay  -->
									<div class="col-12 col-md-2">
										<?php 
											$delay_time =  $arrival_delay." min";
											if($arrival_delay > 60) {
										       $delay_time = intdiv($arrival_delay, 60).' hrs '. ($arrival_delay % 60) ." min";
											}

											if($delay_time > 0) {
												echo "<h5 class='text-danger'>".$delay_time."</h5><p class='text-danger'>Late</p>";
											}else{
												echo "<h5 class='text-success'>No Delay</h5>";
											}
										?>
									</div>
								</div>
						</div>
				</li>
			</ul>
		</div>
		<?php
		
	}

}


	

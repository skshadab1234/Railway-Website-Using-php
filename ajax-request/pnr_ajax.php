
<?php
require '../includes/constant.php';
if(isset($_POST['pnr_number']) || $_POST['pnr_number'] != '') {
	$pnr_number = $_POST['pnr_number']	;
	

	$curl = curl_init();
	
	curl_setopt_array($curl, [
		CURLOPT_URL => "https://irctc1.p.rapidapi.com/api/v2/getPNRStatus?pnrNumber=".$pnr_number."",
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
	
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		
		if(isset($result['errors'])) {
			echo "<p class='text-danger text-center mt-4 fs-4'>".$result['errors'][0]['pnrNumber']."</p>";
		}

		if(isset($result['status']) && $result['status'] == '') {
			echo "<p class='text-danger text-center mt-4 fs-4'>".$result['message']."</p>";
		}

		if(isset($result['status']) && $result['status'] == 1) {
			$data = $result['data'];
			?>
			<!-- DISPLAY PNR STATUS WITH RESPECT TO PNR NUMBER  -->
			<div class="container border p-3 container-md rounded shadow-sm mt-4">
				<div class="row text-center">
					<!-- From Station update by shadab -->
					<div class="col-sm-4">
						<h5><?= $data['boarding_station']['station_code'] ?></h5>
						<p><small><?= $data['boarding_station']['station_name'] ?></small></p>
						<p><?= date("d M, Y", strtotime($data['date'])).' - '.date("H:i", strtotime($data['boarding_station']['departure_time']))  ?></p>
					</div>

					<!-- Train Name and Number  -->
					<div class="col-sm-4">
						<img src="<?= FRONT_SITE_PATH ?>images/train_logo.png" width=30>
						<p><a href=""><?= $data['train_number'] ?></a></p>
						<P><?= $data['train_name'] ?></P>
					</div>

					<!-- to Station  -->
					<div class="col-sm-4">
						<h5><?= $data['reservation_upto']['station_code'] ?></h5>
						<p><small><?= $data['reservation_upto']['station_name'] ?></small></p>
						<p><?= date("d M, Y", strtotime('+'.($data['reservation_upto']['day_count'] - 1).' day', strtotime($data['date']))).' - '.date("H:i", strtotime($data['reservation_upto']['arrival_time']))  ?></p>
					</div>
				</div>
			</div>

			<!-- Table of Confirmed Tickets -->
			<div class="container border p-3 container-md rounded shadow-sm mt-4">
				<table class="table ">
					<thead class="text-center table-primary">
						<tr>
						<th scope="col">Booking Status</th>
						<th scope="col">Age</th>
						<th scope="col">Current Status</th>
						<th scope="col">Confirmation</th>
						</tr>
					</thead>
					<tbody>

					<?php
						$passenger_data = $data['passenger'];

						foreach ($passenger_data as $key => $value) {
							$percentage = 100;
							$color_bg = 'table-success text-success';
							$booking_status = $value['currentCoachId'].', '.$value['currentBerthNo'].', '.$data['quota'];
							$current_status = $value['currentStatus'];
							if($value['currentStatus'] == 'CAN'){
								$percentage = 0;
								$color_bg = 'table-danger text-danger';
								$booking_status = '-----';
								$current_status = '<span class="text-danger">CANCELLED</span>';
							}
							

							?>
							<tr class="text-center">
								<td><?= $booking_status ?></td>
								<td><?= $value['passengerAge'] ?></td>
								<td>
									<h5 class="fs-6"><?= $current_status ?></h5>
									<p>
										<?php
											if(isset($value['currentBerthCode']))	{
												$berthcode = $value['currentBerthCode'];
												if($current_status == 'CNF'){
													switch ($berthcode){
														case 'SL':
															echo '<small>(Side Lower)</small>';
															break;
														case 'LB':
															echo '<small>(Lower)</small>';
															break;
														case 'MB':
															echo '<small>(Middle)</small>';
															break;
														case 'UB':
															echo '<small>(Upper)</small>';
															break;
														case 'SU':
															echo '<small>(Side Upper)</small>';
															break;
														default:
															echo '';
															break;
													}
												}
												
												
											}
										?>
									</p>
								</td>

								<td class="<?= $color_bg ?>">
									<?= $percentage ?>
								%</td>
							</tr>
							<?php
						}
					?>
						
					
					
					
					</tbody>
				</table>
			</div>

			<!-- Pricing -->
			<div class="container border p-3 container-md rounded shadow-sm mt-4">
				<h5 class="fs-6 text-primary">
					<?php
						switch ($data['class']){
							case '2S':
								echo "Second Sitting(2S)";
								break;
							case 'EA':
								echo "Anubhuti Class (EA)";
								break;
							case '1A':
								echo "AC First Class (1A) ";
								break;
							case 'EV':
								echo "Vistadome AC (EV)";
								break;
								
							case 'EC':
								echo "Exec. Chair Car (EC)";
								break;
							case '2A':
								echo "AC 2 Tier (2A)";
								break;

							case 'FC':
								echo "First Class (FC)";
								break;

							case '3A':
								echo "AC 3 Tier (3A)";
								break;

							case '3E':
								echo "AC 3 Economy (3E)";
								break;
							case 'CC':
								echo "AC Chair car (CC)";
								break;
							case 'SL':
								echo "Sleeper (SL) ";
								break;
							case 'VS':
								echo "Vistadome Non AC (VS)";
								break;
							default:
								echo '';
								break;
						}	
					?>
				</h5>
			</div>
			<?php
		}

		// print_r($result);
	}
	
	

}	

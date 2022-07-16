<?php
    require 'includes/header.php';
?>

    <div class="container mt-5 border-left border-right p-3 rounded shadow-sm border-success border-opacity-10">
        <h3 class="text-center">IRCTC Check Seat Availability</h3>
        <div class="container border-left border-right p-3 container-md rounded shadow-sm mt-4">
            <form id="seat_check" >
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 ">
                        <label class="form-label">Enter Train Number</label>
                        <input list="train_nos" type="text" class="form-control col-6" name="train_no" id="train_no" required placeholder="">
						<datalist id="train_nos">
							<option value="15066"  class="form-control col-6">
							<option value="15065" class="form-control col-6">
							<option value="15064" class="form-control col-6">
						</datalist>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 ">
                        <label class="form-label">Start Day</label>
                        <input type="date" class="form-control col-6" name="date" id="date" required placeholder="">
                    </div>
                    <div class="col-12  col-md-6 col-lg-4 mt-1">
                        <button type="submit" id="submit" class="btn btn-primary form-control mt-4 p-2" disabled>Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-block " id="seat_html">
           <div class="container mt-5  p-5">
				<h4 class="text-center">Panvel (PNVL) <img src="https://www.confirmtkt.com/images/Mail/arrow.png" alt="to"> Gorakhpur (GKP)</h4>

				<div class="card p-3 mt-4">
					<h5>15066 - PNVL GKP Express</h5>
				</div>
		   </div>
        </div>
    </div>

<?php
    require 'includes/footer.php';



    ?>

    <script>
            $(document).ready( () => {
                
                $("#train_no").keyup(function() {
                    if($(this).val().length  == 5) {
                        $("#submit").attr('disabled', false);
                        $("#train_no").focusout();
                        $("#seat_check").submit();
                    } else {
                        $("#submit").attr('disabled', true);
                    }
                });
                var front_site_path = $("#front_site_path").val();
                $('#seat_check').on('submit', (e) => {
                    e.preventDefault();
                    const seat_check = $("#seat_check").serialize();
                    $("#submit").attr('disabled', true);
                    $("#submit").html("Wait... Getting Live Status");
                    $.ajax({
                        url : front_site_path+'ajax-request/seat_check_ajax.php',
                        method: 'post',
                        data : seat_check,
                        success: (res) => {
                            $("#seat_html").removeClass("d-none");
                            $("#seat_html").addClass("d-block");
                            $("#seat_html").html(res)
                            $("#submit").attr('disabled', false);
                            $("#submit").html("Search");
                            console.log(res);
                        }       
                    })
                });
            });
    
        </script>
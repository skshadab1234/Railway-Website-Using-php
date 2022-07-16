<?php
     include 'includes/header.php';
?>

<div class="container mt-5 border-left border-right p-3 rounded shadow-sm border-success border-opacity-10">
        <h3 class="text-center">Check Train Schedule & Route</h3>

        <!-- Search PNR FORM  -->
        <div class="container border-left border-right p-3 container-md rounded shadow-sm mt-4">
            <form id="train_schedule_submit" >
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 ">
                        <label class="form-label">Enter Train Name / Number</label>
                        <input type="text" class="form-control col-6" name="train_no" id="train_no" required placeholder="">
                    </div>
                    <div class="col-12  col-md-6 col-lg-4 mt-1">
                        <button type="submit" id="submit" class="btn btn-primary form-control mt-4 p-2" disabled>Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-block " id="train_schedule">
            <div class="row search_data">
               
            </div>
        </div>
    </div>

<?php
    include 'includes/footer.php';
?>

<script>
        $(document).ready( () => {
            
            $("#train_no").keyup(function() {
                if($(this).val().length  == 5) {
                    $("#submit").attr('disabled', false);
                    // $("#train_schedule_submit").submit();
                } else {
                    $("#submit").attr('disabled', true);
                }

                // Search TRain Results on keyup 
                if($(this).val().length > 2){
                    $(this).trigger('blur');
                    var train_no = $(this).val();
                    $.ajax({
                    url : front_site_path+'ajax-request/train_list.php',
                    method: 'post',
                    data : "train_no="+train_no,
                    success: (res) => {
                        $("#train_schedule .row").html(res)
                    }       
                })
                }
            });
            var front_site_path = $("#front_site_path").val();
            $('#train_schedule_submit').on('submit', (e) => {
                e.preventDefault();
                const train_schedule_submit = $("#train_schedule_submit").serialize();
                $("#submit").attr('disabled', true);
                $("#submit").html("Wait... Getting Timetable");
                $.ajax({
                    url : front_site_path+'ajax-request/train_sch_ajax.php',
                    method: 'post',
                    data : train_schedule_submit,
                    success: (res) => {
                        $("#train_schedule").removeClass("d-none");
                        $("#train_schedule").addClass("d-block");
                        $("#train_schedule .search_data").html(res)
                        $("#submit").attr('disabled', false);
                        $("#submit").html("Search");
                    }       
                })
            });
        });

    </script>
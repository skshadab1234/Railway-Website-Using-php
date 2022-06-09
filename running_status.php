<?php
    require 'includes/header.php';
?>

    <div class="container mt-5 border-left border-right p-3 rounded shadow-sm border-success border-opacity-10">
        <h3 class="text-center">IRCTC Live Train Running Status</h3>
        <div class="container border-left border-right p-3 container-md rounded shadow-sm mt-4">
            <form id="running_submit" >
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 ">
                        <label class="form-label">Enter Train Number</label>
                        <input type="text" class="form-control col-6" name="train_no" id="train_no" required placeholder="">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 ">
                        <label class="form-label">Start Day</label>
                        <select class="form-select" name="start_day" aria-label="Default select example">
                            <option selected value="0">Today</option>
                            <option value="1">Yesterday</option>
                            <option value="2">2 Day ago</option>
                            <option value="3">3 Day ago</option>
                            <option value="4">4 Day ago</option>
                        </select>
                    </div>
                    <div class="col-12  col-md-6 col-lg-4 mt-1">
                        <button type="submit" id="submit" class="btn btn-primary form-control mt-4 p-2" disabled>Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-block " id="running_status">
           
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
                        $("#running_submit").submit();
                    } else {
                        $("#submit").attr('disabled', true);
                    }
                });
                var front_site_path = $("#front_site_path").val();
                $('#running_submit').on('submit', (e) => {
                    e.preventDefault();
                    const running_submit = $("#running_submit").serialize();
                    $("#submit").attr('disabled', true);
                    $("#submit").html("Wait... Getting Timetable");
                    $.ajax({
                        url : front_site_path+'ajax-request/running_ajax.php',
                        method: 'post',
                        data : running_submit,
                        success: (res) => {
                            $("#running_status").removeClass("d-none");
                            $("#running_status").addClass("d-block");
                            $("#running_status").html(res)
                            $("#submit").attr('disabled', false);
                            $("#submit").html("Search");
                            console.log(res);
                        }       
                    })
                });
            });
    
        </script>
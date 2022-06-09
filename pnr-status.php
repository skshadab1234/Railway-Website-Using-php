<?php

    require 'includes/header.php';
?>

    <div class="container mt-5 border-left border-right p-3 rounded shadow-sm border-success border-opacity-10">
        <h3 class="text-center">IRCTC PNR Status Check</h3>

        <!-- Search PNR FORM  -->
        <div class="container border-left border-right p-3 container-md rounded shadow-sm mt-4">
            <form id="pnr_submit">
                <label class="form-label">PNR Number</label>
                <input type="number" class="form-control" name="pnr_number" required placeholder="Enter 10 Digit PNR">
                <button type="submit" class="btn btn-primary form-control mt-2">Search</button>
            </form>
        </div>


      <div class="d-none" id="pnr_status">
        
      </div>
    </div>


    
<?php
    require 'includes/footer.php';
?>
    <script>
        $(document).ready( () => {

            var front_site_path = $("#front_site_path").val();
            $('#pnr_submit').on('submit', (e) => {
                e.preventDefault();
                const pnr_data = $("#pnr_submit").serialize();
                
                $.ajax({
                    url : front_site_path+'ajax-request/pnr_ajax.php',
                    method: 'post',
                    data : pnr_data,
                    success: (res) => {
                        console.log(res);
                        $("#pnr_status").removeClass("d-none");
                        $("#pnr_status").addClass("d-block");
                        $("#pnr_status").html(res)
                    }       
                })
            });
        });

    </script>
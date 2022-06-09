<?php

require '../simple_html_dom.php';
include "../includes/functions.php";


if(isset($_POST['train_no']) && $_POST['train_no'] != '') {
    $t_no = $_POST['train_no'];
    $route_array = getTimeTable($t_no);
    if(isset($route_array['error'])) {
        ?>

            <div class="container">
                <h5 class="text-danger">
                    <?= $route_array['error'] ?>
                </h5>
            </div>

        <?php
    }else{
        
    ?>
        <div class="container border-left border-right p-3 container-md rounded shadow-sm mt-4">
                <h4 class="text-center"><?= $route_array['train_name'] ?></h4>
                <div class="row">
                    <!-- Runs On  -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <p class="mt-4">
                            <?= $route_array['runs_on'] ?>
                        </p>
                    </div>
                    <!-- Pantry Car  -->
                    <div class="col-12 col-sm-6 col-md-4 text-center">
                        <h6 class="mt-3 pt-2"><?= $route_array['pantry_car'] ?></h6>
                    </div>

                    <!-- Class Available -->
                    <div class="col-12 col-sm-6 col-md-4 text-center">
                        <h6 class="mt-2 pt-3">
                            <?= $route_array['class'] ?> 
                        </h6>
                    </div>

                    <table class="table mt-5 table-bordered table-striped">
                        <thead class="table-primary text-center">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Station</th>
                            <th scope="col">Arrival Departure</th>
                            <th scope="col">Halt</th>
                            <th scope="col">Day</th>
                            <th scope="col">Distance</th>
                            <th scope="col">Platform</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $train_route = $route_array['route'];

                                foreach($train_route as $key => $val) {
                                    ?>
                                        <tr class="text-center">
                                            <th scope="row"><?= $key + 1 ?></th>
                                            <td><?= $val['stn_name'] ?> <br> ( <?= $val['stn_code'] ?> )</td>
                                            <td>
                                                <?= $val['start'] ?>
                                            </td>
                                            <td><?= $val['halt'] ?></td>
                                            <td><?= $val['day_count'] ?></td>
                                            <td><?= $val['distance_covered'] ?></td>
                                            <td><?= $val['platform'] ?></td>
                                        </tr>
                                    <?php
                                }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
    <?php
    }
}


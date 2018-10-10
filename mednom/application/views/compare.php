





<section class="dvAboutus mt55">
    <div class="container table-responsive">

        <table class="table table-bordered table-striped table-hover table-condensed table-responsive mt30">

            <thead>

            <?php

            if ($products) {

                echo '<tr><th style="width: 22%; text-align:center;vertical-align: middle;background: #12245b;color: #FFFFFF;">Compare  ' . count($products) . ' Items</th>';
                foreach ($products as $product) {
                    echo '<td>';
                    $img = json_decode($product['image_urls'], true);
                    $src = '';
                    if ($img) {
                        $src = $img['small'];
                    }
                    echo '<img src="' . base_url($src) . '"><br>';
                    echo '<a style="font-size: 15px; color: #12245b; font-weight: 600;" href="' . base_url($product['page_url']) . '">' . $product['name'] . '</a>';
                    echo '</td>';
                }
                echo '</tr>';
            }?>
            </thead>
            <tbody>
            <?php foreach ($keys as $k => $item) {
                echo '<tr>';
                echo "<td>" . $k . "</td>";
                if ($item['child']) {
                    foreach ($item['child'] as $v) {
                        if (!$v) {
                            $v = '&mdash;';
                        }
                        echo '<td>' . $v . '</td>';
                    }
                }
                echo '</tr>';
            }

            ?>

            </tbody>

        </table>

    </div>

</section>

<style>



    .table > thead > tr > td, .table > tbody > tr > td {

        text-align: center;

    }

</style>



      <footer id="footer" class="footer-simple footer-dark">


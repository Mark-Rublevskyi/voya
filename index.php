<?php
session_start();
?>
<?php
    include 'blocks/header.php';
?>
        <div class="down-header">
            <div class="voya-bg"></div>
            <div class="wrapper">
                <div class="down-header-content">
                    <div class="down-header-btn">
                        <a href="shirts.php?id=0">Перейти в каталог</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <a name="products"></a>
    <section class="products">
        <div class="wrapper">
            <div class="products-content">
                <div class="row-4">
                    <?php
                        include 'db.php';
                        $res = $dbh->query("select * from products WHERE `sale` IS NOT null and `sale`!= 0 order by `sale` desc ");
                        $res1 = $dbh->query("select * from products WHERE `sale` IS null or `sale`= 0 order by RAND()");
                        $row = $res->fetchAll();
                        $row1 = $res1->fetchAll();
                        foreach ($row as $item) :
                            $img = explode(';',$item['image']);
                            ?>
                            <div class="product-card xs-5 sm-3 md-1">
                                <a href="product.php?id=<?php echo $item['id']; ?>">
                                    <div class="product-image">
                                        <img alt="<?php echo $item['name'] ?>" src="img/<?php echo $img[0]; ?>">
                                        <?php if($item['sale']>0) {?>
                                        <div class="saleProc">
                                            <p><?php echo "-".$item['sale']."%" ?></p> 
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="product-name">
                                        <h2><?php echo $item['name'] ?></h2>
                                    </div>
                                    <div class="cost">
                                        <?php 
                                                if($item['sale']>0) { 
                                                    echo "<p style='text-decoration: line-through; display: 
                                                    inline-block; color: rgb(252, 44, 3);' 
                                                    class='start-cost'>{$item['price']} грн</p>";
                                                    $sum = $item['price']-$item['price']*$item['sale']/100; echo " ".$sum." грн"; 
                                                } else {
                                                    ?>
                                                        <p class="start-cost"><?php echo $item['price']?> грн</p>
                                                    <?php
                                                }
                                        ?>
                                    </div>
                                </a>
                            </div>
                            <?php
                        endforeach;
                        foreach ($row1 as $item) :
                            $img = explode(';',$item['image']);
                            ?>
                            <div class="product-card xs-5 sm-3 md-1">
                                <a href="product.php?id=<?php echo $item['id']; ?>">
                                    <div class="product-image">
                                        <img alt="<?php echo $item['name'] ?>" src="img/<?php echo $img[0]; ?>">
                                    </div>
                                    <div class="product-name">
                                        <h2><?php echo $item['name'] ?></h2>
                                    </div>
                                    <div class="cost">
                                        <?php 
                                                if($item['sale']>0) { 
                                                    echo "<p style='text-decoration: line-through; display: 
                                                    inline-block; color: rgb(252, 44, 3);' 
                                                    class='start-cost'>{$item['price']} грн</p>";
                                                    $sum = $item['price']-$item['price']*$item['sale']/100; echo " ".$sum." грн"; 
                                                } else {
                                                    ?>
                                                        <p class="start-cost"><?php echo $item['price']?> грн</p>
                                                    <?php
                                                }
                                        ?>
                                    </div>
                                </a>
                            </div>
                            <?php
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php
    include 'blocks/footer.html';
?>  
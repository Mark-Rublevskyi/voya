<?php session_start();
?>   
    <?php
        include 'blocks/header.php';
        include 'db.php';
        $str = "select * from products where id={$_GET['id']}";
        $res = $dbh->query($str);
        $row = $res->fetch();
        $img = explode(';', $row['image']);
        $str1 = "select tableofsize.name, sizeproduct.* from products inner join sizeproduct on products.id=sizeproduct.idProduct 
        inner join tableofsize on tableofsize.id=sizeproduct.idSize where products.id={$_GET['id']}";
        $res1 = $dbh->query($str1);
        $row1 = $res1->fetchAll();
    ?>
</script>
    </script>
    <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <title><?php echo $row['name']; ?></title>

    <section class="clothes">
        <div class="wrapper">
            <div class="clothes-content">
                <div class="left-bar">
                    <div id="big">
                        <img src="img/<?php echo $img[0]; ?>" class="minimized">
                    </div>
                    <div id="small">
                        <?php 
                            foreach($img as $val) {
                                ?>
                                <a href="img/<?php echo $val;?>"><img src="img/<?php echo $val;?>"></a>
                                <?php
                            }
                        ?>
                    </div>
                    <style>
                            figure{
                                width: 150px;
                                background: lightblue;
                                padding: 4px;
                                height: 200px;
                            }
                            ol {
                                display: flex;
                                flex-wrap: wrap;
                            }
                            a img{
                                width: 50px;
                            }
                            .minimized {
                                width: 400px;
                                height: 500px;
                                cursor: pointer;
                                border: 1px solid #FFF;
                            }
                            .minimized:hover {
                                border: 1px solid yellow;
                            }
                                /* увеличенная картинка */
                            #magnify {
                                display: none;
                                /* position: absolute; upd: 24.10.2016 */
                                position: fixed;
                                width: 500px;
                                max-width: 600px;
                                height: auto;
                                z-index: 9999;
                            }
                            #magnify img {
                                width: 100%;
                                height: auto;
                            }
                                /* затемняющий фон */
                            #overlay {
                                display: none;
                                background: #000;
                                position: fixed;
                                top: 0;
                                left: 0;
                                height: 100%;
                                width: 100%;
                                opacity: 0.5;
                                z-index: 9990;
                            }
                            #close-popup {
                                width: 30px;
                                height: 30px;
                                background: #FFFFFF;
                                border: 1px solid #AFAFAF;
                                border-radius: 15px;
                                cursor: pointer;
                                position: absolute;
                                top: 15px;
                                right: 15px;
                            }
                            #close-popup i {
                                width: 30px;
                                height: 30px;
                                background: url(https://codernote.ru/files/cross.png) no-repeat center center;
                                background-size: 16px 16px;
                                display: block;
                            }
                            @keyframes rota {
                                25% { transform: rotate(360deg); }
                            }
                            #close-popup:hover {
                                animation: rota 4s infinite normal;
                                -webkit-animation-iteration-count: 1;
                                animation-iteration-count: 1;
                            }
                    </style>
                </div>   
                <div class="right-bar">
                    <div class="clothes-title">
                        <h2><?php echo $row['name']; ?></h2>
                    </div>
                    <form action="tobasket.php" method="POST" id="product-form">
                        <div class="clothes-cost">
                            <?php 
                                if($row['sale']>0) { 
                                    echo "<p style='text-decoration: line-through; display: 
                                    inline-block; color: rgb(252, 44, 3);' 
                                    class='start-cost'>{$row['price']} грн</p>";
                                    $sum = $row['price']-$row['price']*$row['sale']/100; echo " ".$sum." грн"; 
                                } else {
                                    ?>
                                        <p class="start-cost"><?php echo $row['price']?> грн</p>
                                    <?php
                                }
                            ?> 
                        </div>
                        <div class="clothes-table-size">
                            <div class="clothes-size">
                                <?php 
                                    foreach($row1 as $value) :
                                        ?>
                                            <label for="<?php echo $value['id']; ?>">
                                                <input type="radio" name="size" checked required value="<?php echo $value['name']; ?>" id="<?php echo $value['id']; ?>">
                                                <p><?php echo $value['name']; ?></p>
                                            </label>
                                        <?php
                                    endforeach;
                                ?>
                            </div>
                            <!-- <div class="table-size">
                                <a>Таблица размеров</a>
                            </div> -->
                        </div>
                        <div class="description">
                            <p><?php echo $row['description']; ?></p>
                        </div>
                        <?php 
                            if(!empty($row['material'])) {
                                ?>
                                    <ul class="clothes-material">
                                        <li><?php echo $row['material'] ?></li>
                                    </ul>
                                <?php
                            }
                        ?>
                        <script src="js/jquery.js"></script>
                        <script>
                            $(document).ready(function() {
                                let count = document.getElementById("countProd").innerText;
                                setTimeout(function(){
                                    $("#dropBasket").removeClass("hidden");
                                },1000);
                                $("#dropBasket").show("slow").delay(10000).hide("slow");
                            });
                            
                        </script>
                        <div class="to-basket">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            <button type="submit" name="tobasket"><span class="fal fa-shopping-bag"></span>Добавить в корзину</button>
                        </div>
                    </form>
                    <div class="have-a-question">
                        <div class="question-title">
                            <p>Есть вопросы?</p>
                        </div>
                        <div class="question-btns">
                            <a href="https://wa.me/380636757423"><span class="fab fa-whatsapp"></span> WhatsApp</a>
                            <a href="https://instagram.com/voya.brand?igshid=1ysphixthvc0"><span class="fab fa-instagram"></span> Instagram</a>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script type="text/javascript" src="http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="js/main.js"></script>

    <?php
        include 'blocks/footer.html';
    ?>
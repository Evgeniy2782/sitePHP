
<div class="container">
  <!--  <div class = "jumbotron">
      <h1 class="display-4">My shop</h1>
      <p class = "lead">Information</p>
    </div>
 
     
    <div class="row">
      <div class="col-lg-3">

        <h1 class="my-4">Shop Name</h1>
        <div class="list-group">
          <a href="#" class="list-group-item">Category 1</a>
          <a href="#" class="list-group-item">Category 2</a>
          <a href="#" class="list-group-item">Category 3</a>
        </div>

      </div>
       /.col-lg-3 -->
 
    <div class = "jumbotron">
      <h1 class="display-6 text-center" >Корзина </h1>
      <p class = "lead text-center">Information  </p>
    </div>
  
      <div class="col-lg-12 md-5">

        <div class="row">

        <?php foreach($qetCart as $item): ?>
          
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="<?=$item["image"];?>" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <h4>
                   Товар <?=$item["item"];?>
                </h4>
                <p class="card-text">описание  <?=$item["description"];?></p>
                <p class="card-text">цена  <?=$item["price"];?> руб.</p>
               
                <a href="/api/cartDelete/<?=$item["uuid"];?>" type="button" class="btn btn-outline-primary">Удалить</a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>



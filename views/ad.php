<?php

?>
<?php foreach ($data as $ad): ?>
<div class="my-ad">
    <div class="card text-center">
        <div class="card-header">
            Block advertising
        </div>
        <div class="card-body">
            <h4 class="card-title"><?=$ad['title']?></h4>
            <h5 class="card-title price"><?=$ad['price']?></h5>
            <p class="card-text"><?=$ad['content']?></p>
            <a href="#" class="btn btn-primary">Переход</a>
        </div>
        <div class="card-footer text-muted">
            As advertising
        </div>
    </div>

    <div class="popover fade show bs-popover-left" role="tooltip">
        <div class="arrow"></div>
        <h3 class="popover-header text-center">Скидка!</h3>
        <div class="popover-body">Купон на скидку  - <?=uniqid()?> – перейдите и получите скидку 10%</div>
    </div>
</div>
<?php endforeach;
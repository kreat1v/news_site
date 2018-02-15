<?php
// Представление контроллера Contacts - форма обратной связи.

$session = \App\Core\App::getSession();

?>
<div class="row">
    <div class="col-12">
        <h1>Leave your message</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form method="post">
            <?php if (!$session->get('id')): ?>
            <div class="form-group">
                <label for="exampleInputName1">How can we apply to you?</label>
                <input type="text" class="form-control" name="name" id="exampleInputName1" placeholder="Your name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter email">
            </div>
            <?php endif; ?>
            <div class="form-group">
	            <?php if (!$session->get('id')): ?>
                    <label for="exampleInputMessages1">Messages</label>
                <?php else: ?>
                    <label for="exampleInputMessages1">Message from <?=$session->get('email')?></label>
	            <?php endif; ?>
                <textarea rows="5" name="messages" id="exampleInputMessages1" class="form-control" placeholder="Your message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</div>
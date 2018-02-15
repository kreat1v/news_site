<?php
$router = \App\Core\App::getRouter();
?>

    <div class="col-lg-12">

        <h2>Users</h2>

        <br />
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">First Name</th>
                <th scope="col">Second Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Active</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach ($data as $user): ?>
                <tr>
                    <td><?=$user['id']?></td>
                    <td><?=$user['firstName']?></td>
                    <td><?=$user['secondName']?></td>
                    <td><?=$user['email']?></td>
                    <td>
	                    <?=$user['role']?>
                        <?php if ($user['role'] == 'user'): ?>
                            <a class="btn btn-sm btn-danger" style="float: right" onclick="return confirmDelete()" href="<?=$router->buildUri('editrole', [$user['id'], 'admin'])?>">Make admin</a>
                        <?php else: ?>
                            <a class="btn btn-sm btn-success" style="float: right" onclick="return confirmDelete()" href="<?=$router->buildUri('editrole', [$user['id'], 'user'])?>">Make user</a>
                        <?php endif; ?>
                    </td>
                    <td>
	                    <?php if ($user['active'] == '1'):
                            echo 'active';
                            ?>
                            <a class="btn btn-sm btn-danger" style="float: right" onclick="return confirmDelete()" href="<?=$router->buildUri('editactive', [$user['id'], 0])?>">Deactivate</a>
	                    <?php else:
                            echo 'inactive';
                            ?>
                            <a class="btn btn-sm btn-success" style="float: right" onclick="return confirmDelete()" href="<?=$router->buildUri('editactive', [$user['id'], 1])?>">Activate</a>
	                    <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
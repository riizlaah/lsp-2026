<x-main>
    <h1>Users</h1>
    <ul>
        <?php foreach($users ?? [] as $user): ?>
            <li>
                <form action="/users/edit/<?= $user->id ?>" method="post">
                    <xm-put />
                    <xcsrf />
                    <input type="email" name="email" value="<?= $user->email ?>">
                    <br>
                    <input type="text" name="fullName" value="<?= $user->fullName ?>">
                    <br>
                    <button type="submit">Simpan</button>
                </form>
                <form action="users/delete/<?= $user->id ?>">
                    <xm-delete>
                    <xcsrf />
                    <button type="submit" onclick="confirm('Anda yakin?')">Hapus</button>
                </form>
                <?php if($user->posts): ?>
                    <?php foreach($user->posts as $post): ?>
                        <div style="padding: 8px; margin: 4px;">
                            <p><b><?= $post->title ?></b></p>
                            <p><?= $post->content ?></p>
                            <br>
                            <span><?= $post->updatedAt ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="font-style: italic; color: gray;">This user doesn't have any post yet</p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <br>
    <form action="/users" method="post">
        <xcsrf />
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="password" placeholder="Password">
        <input type="text" name="fullName" placeholder="Full Name">
        <input type="email" name="email" placeholder="Email">
        <button type="submit">New</button>
    </form>
</x-main>
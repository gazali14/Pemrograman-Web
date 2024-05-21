<?php
$data = file_get_contents("https://reqres.in/api/users?page=1");
$parse_data = json_decode($data);

if ($parse_data && isset($parse_data->data)) {
    $users = $parse_data->data;
?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Gambar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user->id; ?></td>
                    <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><img src="<?php echo $user->avatar; ?>" alt="Avatar" width="50"></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
} else {
    echo "Data tidak tersedia atau terjadi kesalahan dalam mengambil data.";
}
?>

<?php
// index.php - To-Do List
include "koneksi.php";

// Hapus data jika ada request hapus via GET
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $kon->prepare("DELETE FROM todo WHERE id_todo = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit;
}

// Ambil semua data todo
$result = $kon->query("SELECT * FROM todo ORDER BY id_todo DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>To-Do List</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Navbar -->
  <nav class="bg-blue-600 shadow">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center text-white">
      <a href="index.php" class="flex items-center gap-2">
        <img src="logo.png" alt="Logo" class="w-8 h-8">
        <span class="text-lg font-semibold">My To-Do List</span>
      </a>
      <a href="create.php" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Tambah Tugas
      </a>
    </div>
  </nav>

  <!-- Konten -->
  <div class="max-w-4xl mx-auto mt-6 px-4">
    <h4 class="text-center text-xl font-semibold mb-4">Daftar Tugas</h4>

    <?php if (isset($_GET['msg'])): ?>
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        <?php echo htmlspecialchars($_GET['msg']); ?>
      </div>
    <?php endif; ?>

    <div class="overflow-x-auto shadow rounded-lg bg-white">
      <table class="min-w-full border border-gray-200 text-sm text-center">
        <thead class="bg-blue-500 text-white">
          <tr>
            <th class="py-2 px-3">No</th>
            <th class="py-2 px-3">Tugas</th>
            <th class="py-2 px-3">Status</th>
            <th class="py-2 px-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 0;
          while ($row = $result->fetch_assoc()) {
              $no++;
          ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="py-2 px-3"><?php echo $no; ?></td>
              <td class="py-2 px-3 text-left font-bold"><?php echo htmlspecialchars($row['task']); ?></td>
              <td class="py-2 px-3">
                <?php if($row['status'] == 'selesai'): ?>
                  <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Selesai</span>
                <?php else: ?>
                  <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs">Belum</span>
                <?php endif; ?>
              </td>
              <td class="py-2 px-3 space-x-2">
                <a href="edit.php?id_todo=<?php echo $row['id_todo']; ?>" 
                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                <a href="index.php?hapus=<?php echo $row['id_todo']; ?>" 
                   class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                   onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</a>
              </td>
            </tr>
          <?php } ?>
          <?php if ($result->num_rows == 0): ?>
            <tr>
              <td colspan="4" class="py-4 text-gray-500">Belum ada tugas.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

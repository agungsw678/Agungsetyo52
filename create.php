<?php
// create.php
include "koneksi.php";

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = trim($_POST['task'] ?? '');
    $status = $_POST['status'] ?? 'belum';

    if ($task === '') {
        $err = "Tugas wajib diisi.";
    } else {
        $stmt = $kon->prepare("INSERT INTO todo (task, status) VALUES (?, ?)");
        $stmt->bind_param("ss", $task, $status);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php?msg=" . urlencode("Tugas berhasil ditambahkan"));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-blue-600 shadow">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center text-white">
            <div class="flex items-center space-x-3">
                <img src="logo.png" alt="Logo" class="w-8 h-8">
                <span class="text-lg font-semibold">Tambah Tugas</span>
            </div>
            <a href="index.php" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-white font-medium transition">
                Kembali
            </a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-2xl bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">Form Tambah Tugas</h2>

            <?php if ($err): ?>
              <div class="mb-4 p-3 rounded-md bg-red-100 text-red-700 text-sm">
                <?php echo htmlspecialchars($err); ?>
              </div>
            <?php endif; ?>

            <form method="post" class="grid grid-cols-1 gap-4">
                <!-- Tugas -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tugas</label>
                    <input type="text" name="task" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="belum">Belum</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-3 mt-4">
                    <a href="index.php"
                       class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 font-medium transition">Batal</a>
                    <button type="submit"
                            class="px-5 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-white font-medium transition">Simpan</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

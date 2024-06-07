class Buku {
  
    public static function semua() {
   
        $query = "SELECT * FROM buku";
        $result = $database->query($query);
        $bukuList = [];
        while ($row = $result->fetch_assoc()) {
            $bukuList[] = new Buku($row);
        }
        return $bukuList;
    }

    public static function hapus($id) {

        $query = "DELETE FROM buku WHERE id = ?";
        $stmt = $database->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

}

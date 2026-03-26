<?php

include __DIR__ . "/../models/Band.php";
include __DIR__ . "/../models/Album.php";
include __DIR__ . "/../models/AlbumBand.php";


class DbContext {
    // mysql connection properties
    private string $_host = "localhost";
    private string $_user = "proj1a_user";
    private string $_pass = "password";
    private string $_db = "proj1a";
    private mysqli $_conn;


    function __construct() {
        $this->_conn = new mysqli($this->_host, $this->_user, $this->_pass, $this->_db);
    }

    function __destruct() {
        $this->_conn->close();
    }


    // ── ALBUMBAND (home page) ──────────────────────────────

    function GetAlbumsAndBands(string $search = "") : array {
        $AlbumBands = array();

        if ($search == "") {
            $query = "SELECT Albums.AlbumID, Albums.Title, Albums.ReleaseDate,
                             Bands.BandID, Bands.Name
                      FROM Albums
                      JOIN Bands ON Albums.BandID = Bands.BandID
                      ORDER BY Bands.Name, Albums.Title";
            $result = $this->_conn->query($query);
        }
        else {
            $query = "SELECT Albums.AlbumID, Albums.Title, Albums.ReleaseDate,
                             Bands.BandID, Bands.Name
                      FROM Albums
                      JOIN Bands ON Albums.BandID = Bands.BandID
                      WHERE Bands.Name LIKE ? OR Albums.Title LIKE ?
                      ORDER BY Bands.Name, Albums.Title";
            $stmt = $this->_conn->prepare($query);
            $like = "%{$search}%";
            $stmt->bind_param("ss", $like, $like);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if ($result->num_rows > 0) {
            while ($ab = $result->fetch_object("AlbumBand")) {
                array_push($AlbumBands, $ab);
            }
        }

        return $AlbumBands;
    }


    // ── ALBUMS ─────────────────────────────────────────────

    function CreateAlbum(Album $Album) : bool {
        $query = "INSERT INTO Albums (Title, ReleaseDate, BandID) VALUES ";
        $query .= "('{$Album->Title}', '{$Album->ReleaseDate}', {$Album->BandID})";
        return $this->_conn->query($query);
    }

    function GetAlbum(int $id) : Album {
        $Album = new Album();

        $query = "SELECT * FROM Albums WHERE AlbumID = {$id}";
        $result = $this->_conn->query($query);

        if ($result->num_rows > 0) {
            $Album = $result->fetch_object("Album");
        }

        return $Album;
    }

    function UpdateAlbum(Album $Album) : bool {
        $query = "UPDATE Albums SET Title = '{$Album->Title}',
                  ReleaseDate = '{$Album->ReleaseDate}',
                  BandID = {$Album->BandID}
                  WHERE AlbumID = {$Album->AlbumID}";
        return $this->_conn->query($query);
    }

    function DeleteAlbum(int $id) : bool {
        $query = "DELETE FROM Albums WHERE AlbumID = {$id}";
        return $this->_conn->query($query);
    }


    // ── BANDS ──────────────────────────────────────────────

    function GetAllBands() : array {
        $AllBands = array();

        $query = "SELECT * FROM Bands ORDER BY Name";
        $result = $this->_conn->query($query);

        if ($result->num_rows > 0) {
            // loop over results, get each band record, add to allbands array
            while ($b = $result->fetch_object("Band")) {
                array_push($AllBands, $b);
                //$AllBands[] = $b;
            }
        }

        return $AllBands;
    }

    function CreateBand(Band $Band) : bool {
        $query = "INSERT INTO Bands (Name) VALUES ('{$Band->Name}')";
        return $this->_conn->query($query);
    }

    function GetBand(int $id) : Band {
        $Band = new Band();

        $query = "SELECT * FROM Bands WHERE BandID = {$id}";
        $result = $this->_conn->query($query);

        if ($result->num_rows > 0) {
            $Band = $result->fetch_object("Band");
        }

        return $Band;
    }

    function UpdateBand(Band $Band) : bool {
        $query = "UPDATE Bands SET Name = '{$Band->Name}'
                  WHERE BandID = {$Band->BandID}";
        return $this->_conn->query($query);
    }

    function DeleteBand(int $id) : bool {
        $query = "DELETE FROM Bands WHERE BandID = {$id}";
        return $this->_conn->query($query);
    }
}

?>

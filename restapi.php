<?php

   require_once "koneksi.php";

   if (function_exists($_GET['method'])) {
      $_GET['method']();
   }

   function getNote()
   {
      global $koneksi;
      $query = $koneksi->query("SELECT * FROM note");
      while ($row = mysqli_fetch_object($query)) {
         $data[] = $row;
      }
      $response = array(
         'status' => 200,
         'message' => 'success',
         'author' => 'Danendra Coding',
         'data' => $data
      );
      header('Content-Type: application/json');
      echo json_encode($response);
   }

   function getNoteId()
   {
      global $koneksi;
      if (!empty($_GET["id"])) {
         $id = $_GET["id"];
      }
      $query = "SELECT * FROM note WHERE id= $id";
      $result = $koneksi->query($query);
      while ($row = mysqli_fetch_object($result)) {
         $data[] = $row;
      }
      if ($data) {
         $response = array(
            'status' => 200,
            'message' => 'success',
            'author' => 'Danendra Coding',
            'data' => $data
         );
      } else {
         $response = array(
            'status' => 404,
            'message' => 'error'
         );
      }

      header('Content-Type: application/json');
      echo json_encode($response);
   }

   function addNote()
   {
      global $koneksi;
      $check = array('judul' => '', 'catatan' => '', 'tanggal' => '');
      $check_match = count(array_intersect_key($_POST, $check));
      if ($check_match == count($check)) {

         $result = mysqli_query($koneksi, "INSERT INTO note SET
                  judul = '$_POST[judul]',
                  catatan = '$_POST[catatan]',
                  tanggal ='$_POST[tanggal]'");

         if ($result) {
            $response = array(
               'status' => 200,
               'message' => 'success'
            );
         } else {
            $response = array(
               'status' => 404,
               'message' => 'error'
            );
         }
      } else {
         $response = array(
            'status' => 404,
            'message' => 'error'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

   function updateNote()
   {
      global $koneksi;
      if (!empty($_GET["id"])) {
         $id = $_GET["id"];
      }
      $check = array('judul' => '', 'catatan' => '', 'tanggal' => '');
      $check_match = count(array_intersect_key($_POST, $check));
      if ($check_match == count($check)) {

         $result = mysqli_query($koneksi, "UPDATE note SET               
                  judul = '$_POST[judul]',
                  catatan = '$_POST[catatan]',
                  tanggal = '$_POST[tanggal]' WHERE id = $id");

         if ($result) {
            $response = array(
               'status' => 200,
               'message' => 'success'
            );
         } else {
            $response = array(
               'status' => 404,
               'message' => 'error'
            );
         }
      } else {
         $response = array(
            'status' => 404,
            'message' => 'error',
            'data' => $id
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

   function deleteNote()
   {
      global $koneksi;
      $id = $_GET['id'];
      $query = "DELETE FROM note WHERE id=" . $id;
      if (mysqli_query($koneksi, $query)) {
         $response = array(
            'status' => 200,
            'message' => 'success'
         );
      } else {
         $response = array(
            'status' => 404,
            'message' => 'error'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

?>
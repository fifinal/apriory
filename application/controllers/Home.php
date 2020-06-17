<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Rule_model');
        $this->load->model('Transaksi_model');
        $this->load->model('Produk_model');
        $this->load->library('excel');
        // $this->transaksi = [
        //     "1" => ["c", "e", "d"],
        //     "2" => ["a", "f", "d"],
        //     "3" => ["d", "g", "b", "f"],
        //     "4" => ["e", "d", "g", "b"],
        //     "5" => ["b", "a", "c"],
        //     "6" => ["f", "a", "b", "g"],
        //     "7" => ["g", "d"],
        //     "8" => ["c", "g", "e"],
        //     "9" => ["f", "a", "b"],
        //     "10" => ["b", "d"],
        // ];
        // $this->transaksi = [
        //     "a" => ["1", "3", "4"],
        //     "b" => ["2", "3", "5"],
        //     "c" => ["1", "2", "3", "5"],
        //     "d" => ["2", "5"]
        // ];
        // $this->transaksi = [
        //     "1" => ["p", "r", "m"],
        //     "2" => ["r", "m", "t", "s"],
        //     "3" => ["b", "t", "s"],
        //     "4" => ["r", "m"],
        //     "5" => ["r", "m", "k", "t", "s"]
        // ];
        $this->transaksi = [];
        $this->minFrekuensi = 5;
        $this->itemSet = [];
    }
    public function index()
    {
        $this->load->view('excel_import');

        // // ====================================================================//

        // $supportConf = [];
        // foreach ($itemSetFilter as $item) {
        //     foreach ($transaksi as $key => $val) {
        //         $arrVariasi = explode(",", $item);
        //         if (in_array($arrVariasi[0], $val) && in_array($arrVariasi[1], $val)) {
        //             $itemSetFrekuensi[$item] = isset($itemSetFrekuensi[$item]) ?
        //                 $itemSetFrekuensi[$item] + 1 : 1;
        //         }
        //     }
        //     $support = $itemSetFrekuensi[$item] / count($transaksi) * 100;
        //     $conf = 0;
        //     $hasil = [
        //         "key" => $item,
        //         "support" => $support,
        //         "confident" => $conf
        //     ];
        //     array_push($supportConf, $hasil);
        // }
        // print_r($supportConf);
    }
    public function tes()
    {
        $this->transaksi = [];

        $nameFile = $_FILES["file"]["name"];

        if ($nameFile) {

            $idTransksi = "";
            // $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
            // $cacheSettings = array('memoryCacheSize' => '512MB');
            // PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
            // $object = PHPExcel_IOFactory::load($_FILES["file"]["tmp_name"]);
            // foreach ($object->getWorksheetIterator() as $worksheet) {
            //     $highestRow = $worksheet->getHighestRow();
            //     $highestColumn = $worksheet->getHighestColumn();
            //     for ($row = 2; $row <= $highestRow; $row++) {
            //         $kolom1 = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
            //         $kolom1 = trim(explode("-", $kolom1)[0]);
            //         $kolom3 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            //         $kolom4 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            //         $kolom5 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            //         if ($kolom1 != null) {
            //             if (substr($kolom1, 0, 3) == "PJO") {
            //                 $idTransksi = $kolom1;
            //                 $this->transaksi[$idTransksi] = [];
            //             } else if (
            //                 $idTransksi != "" &&
            //                 $kolom3 != "" &&
            //                 $kolom4 != "" &&
            //                 $kolom5 != "" &&
            //                 trim(strtolower($kolom3)) != "" &&
            //                 substr($kolom3, 0, 3) != "100" &&
            //                 $kolom3 != "9999991" &&
            //                 is_numeric($kolom3)
            //             ) {
            //                 array_push($this->transaksi[$idTransksi], trim(strtolower($kolom3)));
            //             }
            //         }
            //     }
            // }

            $object = new PHPExcel_Reader_CSV();
            $load = $object->load($_FILES["file"]["tmp_name"]);
            $sheet = $load->getActiveSheet()->toArray(null, true, true);

            $idTransksi = "";
            $produks = [];

            for ($i = 0; $i < count($sheet); $i++) {
                $kolom1 = explode("-", $sheet[$i][0]);
                $kd_transaksi = trim($kolom1[0]);
                if ($kd_transaksi != null) {
                    if (substr($kd_transaksi, 0, 3) == "PJO") {
                        $idTransksi = $kd_transaksi;
                        $tgl = trim($kolom1[1]);
                        $this->transaksi[$idTransksi] = [];
                    } else if (
                        $idTransksi != "" &&
                        $sheet[$i][2] != "" &&
                        $sheet[$i][3] != "" &&
                        $sheet[$i][4] != "" &&
                        trim(strtolower($sheet[$i][2])) != "kode" &&
                        substr($sheet[$i][2], 0, 3) != "100" &&
                        $sheet[$i][2] != "9999991" &&
                        is_numeric($sheet[$i][2])
                    ) {
                        // array_push($transaksi[$idTransksi], $sheet[$i][0] . "," . $sheet[$i][2] . "," . $sheet[$i][3]);
                        $transaksi = [
                            "kode_transaksi" => $idTransksi,
                            "kode_produk" => $sheet[$i][2],
                            "tanggal" => $tgl
                        ];
                        $harga = explode(".", $sheet[$i][4]);
                        $harga = str_replace(",", ".", $harga[0]);
                        $produk = [
                            "kode_produk" => $sheet[$i][2],
                            "nama_produk" => $sheet[$i][3],
                            "harga" => (int) $harga * 1000,
                            "stok" => 10
                        ];

                        $exist = $this->Produk_model->produkById(trim($sheet[$i][2]));

                        if ($exist == null) {
                            $this->Produk_model->saveProduk($produk);
                        }
                        // $this->Transaksi_model->saveTransaksi($transaksi);

                        // array_push($this->transaksi[$idTransksi], trim(strtolower($sheet[$i][2])));
                    }
                }
            }


            echo json_encode($this->transaksi);
            // $this->prosesApriori();
        }
    }

    // public function simpanDaftarRule()
    // {
    //     $data = json_decode(trim(file_get_contents('php://input')), true);
    //     echo $this->Rule_model->simpanDaftarRule($data);
    // }
    public function simpanRule()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        $this->Rule_model->simpanRule($data);
    }
    private function prosesApriori()
    {
        $items = [];
        $itemsFrekuensi = [];
        foreach ($this->transaksi as $key => $val) {
            foreach ($val as $item) {
                $items[$item] = isset($items[$item]) ? $items[$item] + 1 : 1;
            }
        }

        $itemsFilter = [];
        foreach ($items as $key => $val) {
            if ($val >= $this->minFrekuensi) {
                array_push($itemsFilter, ["items" => $key, "frekuensi" => $val]);
            }
        }

        // $arr = array_slice(explode(",", "a,b,c,d,e,f"), 0, 5);

        // print_r($itemsFilter);
        array_push($this->itemSet, $itemsFilter);

        $this->prosesIterasi($itemsFilter);
        // $this->ruleAssosiatif();
    }

    public function prosesIterasi($itemsFilter)
    {
        $itemSetFilter = [];
        $variasi = "";
        for ($i = 0; $i < count($itemsFilter); $i++) {
            //[a,b] [a,c] [a,d]
            for ($j = $i + 1; $j < count($itemsFilter); $j++) {
                $arrItems = explode(",", $itemsFilter[$i]["items"]);

                if (count($arrItems) > 1) {
                    array_pop($arrItems);

                    $arrItemsTujuan = explode(",", $itemsFilter[$j]["items"]);
                    $arrItemsTujuan2 = end($arrItemsTujuan);
                    array_pop($arrItemsTujuan);
                    if ($this->validasi($arrItems, $arrItemsTujuan)) {
                        $variasi = $itemsFilter[$i]["items"] . "," . $arrItemsTujuan2;
                        $frekuensi = $this->getFrekuensi($variasi);
                        if ($frekuensi >= $this->minFrekuensi)
                            array_push($itemSetFilter, ["items" => $variasi, "frekuensi" => $frekuensi]);
                    }
                } else {
                    $variasi = $itemsFilter[$i]["items"] . "," . $itemsFilter[$j]["items"];
                    $frekuensi = $this->getFrekuensi($variasi);
                    if ($frekuensi >= $this->minFrekuensi)
                        array_push($itemSetFilter, ["items" => $variasi, "frekuensi" => $frekuensi]);
                }
            }
        }

        // print_r($this->itemSet);
        if ($variasi == "") {
            echo count($this->itemSet[0]);
            echo json_encode($this->itemSet[0]);
        } else {
            array_push($this->itemSet, $itemSetFilter);
            $this->prosesIterasi($itemSetFilter);
        }
    }

    private function support($variasi)
    {
        return $this->getFrekuensi($variasi) / count($this->transaksi) * 100;
    }
    private function confident($variasi)
    {
        return $this->getFrekuensi($variasi) / $this->getFrekuensi($variasi) * 100;
    }

    private function ruleAssosiatif()
    {

        $itemsFilter = [];
        $arrItemSet = explode(",", $this->itemSet[count($this->itemSet) - 1][0]["items"]);
        for ($i = 0; $i < count($arrItemSet); $i++) {
            array_push($itemsFilter, ["items" => $arrItemSet[$i]]);
        }
        // print_r($itemsFilter);
        // $this->prosesIterasi($itemsFilter);
    }
    private function cariRule($antecendent, $consequent)
    {
        for ($i = 0; $i < count($antecendent); $i++) {
            for ($j = 0; $j < count($antecendent); $j++) {
            }
        }
    }
    private function getFrekuensi($variasi)
    {
        $frekuensi = 0;
        foreach ($this->transaksi as $key => $val) {
            $arrVariasi = explode(",", $variasi);

            if ($this->validasi($arrVariasi, $val))
                $frekuensi++;
        }
        return $frekuensi;
    }

    private function validasi($arrVariasi, $val)
    {
        $k = count($arrVariasi);
        $itemBersamaan = 0;

        for ($i = 0; $i < $k; $i++)
            if (in_array($arrVariasi[$i], $val)) $itemBersamaan++;

        return ($itemBersamaan == $k) ? true : false;
    }
}

<?php
include_once('./config.php');

$result_customer = mysqli_query($mysqli, "SELECT * FROM m_customer");
$result_barang = mysqli_query($mysqli, "SELECT * FROM m_barang");
$barang = [];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Input</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Depertamen Produksi</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php">Daftar Transaksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  active" aria-current="page" href="#">Form Input</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <form>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal">
            </div>
            <div class="mb-3">
                <label for="customer" class="form-label">Customer</label>
                <select class="form-select form-control" id="customer" aria-label="Default select example">
                    <?php
                    while ($customer_data = mysqli_fetch_array($result_customer)) {
                        echo '<option value="' . $customer_data['id'] . '">' . $customer_data['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="barang" class="form-label">Barang</label>
                <select class="form-select form-control" id="barang">
                    <?php
                    while ($data_barang = mysqli_fetch_object($result_barang)) {
                        echo '<option value="' . htmlspecialchars(json_encode($data_barang)) . '">' . $data_barang->nama . '</option>';
                        array_push($barang, $data_barang);
                    }
                    ?>
                </select>
                <br>
                <button id="tambah-barang" type="button" class="btn btn-success">Tambah</button>
            </div>
            <div class="mb-3">
                <table class="table" id="tabel-barang">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2"></th>
                            <th scope="col" rowspan="2">No</th>
                            <th scope="col" rowspan="2">Kode Barang</th>
                            <th scope="col" rowspan="2">Nama Barang</th>
                            <th scope="col" rowspan="2">Qty</th>
                            <th scope="col" rowspan="2">Harga Bandrol</th>
                            <th scope="col" colspan="2">Diskon</th>
                            <th scope="col" rowspan="2">Harga Diskon</th>
                            <th scope="col" rowspan="2">Total</th>
                        </tr>
                        <tr>
                            <th scope="col">(%)</th>
                            <th scope="col">Rp</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="mb-3">
                <label for="subtotal" class="form-label">Subtotal</label>
                <h3 id="subtotal">0</h3>
            </div>
            <div class="mb-3">
                <label for="diskon" class="form-label">Diskon</label>
                <input type="number" min=0 class="form-control" id="diskon" value="0">
            </div>
            <div class="mb-3">
                <label for="ongkir" class="form-label">Ongkir</label>
                <input type="number" min=0 class="form-control" id="ongkir" value="0">
            </div>
            <div class="mb-3">
                <label for="total-bayar" class="form-label">Total Bayar</label>

                <h3 id="total-bayar">0</h3>
            </div>

            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script>
        const customerEl = document.getElementById('customer')
        const tanggalEl = document.getElementById('tanggal')
        tanggalEl.valueAsDate = new Date()
        const barangEl = document.getElementById('barang')
        const subtotalEl = document.getElementById('subtotal')
        const diskonEl = document.getElementById('diskon')
        const ongkirEl = document.getElementById('ongkir')
        const totalBayarEl = document.getElementById('total-bayar')
        const tabelBarangEl = document.querySelector('#tabel-barang tbody')
        const tambahBarangEl = document.getElementById('tambah-barang')
        const submitEl = document.getElementById('submit')
        let itemBarangEl = document.querySelectorAll('.item-barang');
        let itemNo = document.querySelectorAll('.item-no');
        let hapus = document.querySelectorAll('.hapus');
        let qty = document.querySelectorAll('.qty');
        let diskon = document.querySelectorAll('.diskon');
        let diskonRp = document.querySelectorAll('.diskon-rp');
        let hargaDiskon = document.querySelectorAll('.harga-diskon');
        let total = document.querySelectorAll('.total');

        const reqObj = {

            tgl: new Date(),
            cust_id: 0,
            barangs: [],
            subtotal: 0,
            diskon: 0,
            ongkir: 0,
            total_biaya: 0
        }

        submitEl.addEventListener('click', e => {
            e.preventDefault()
            if (reqObj.barangs.length !== 0) {
                reqObj.tgl = new Date(tanggalEl.value)
                reqObj.cust_id = parseInt(customerEl.value)

                fetch('tambah.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json; charset=UTF-8'
                        },
                        body: JSON.stringify(reqObj)
                    })
                    .then(response => response.json()).then(data => window.location.href = "./");
            }
        })

        const setNo = () => {
            itemNo.forEach((e, i) => {
                e.innerText = i + 1
            })
        }

        const calcTotal = () => {
            console.log(reqObj.barangs)
            subtotalEl.innerHTML = reqObj.barangs.reduce((a, b) => a + b.total, 0)
            reqObj.subtotal = parseInt(subtotalEl.textContent)

            totalBayarEl.textContent = reqObj.subtotal - parseInt(diskonEl.value) + parseInt(ongkirEl.value)
            console.log(parseInt(diskonEl.value))
            console.log(parseInt(ongkirEl.value))
            reqObj.total_biaya = parseInt(totalBayarEl.textContent)
        }

        const hapusListener = (e, i) => {
            e.preventDefault();
            e.target.parentNode.parentNode.remove()
            itemBarangEl = document.querySelectorAll('.item-barang');
            itemNo = document.querySelectorAll('.item-no');
            hapus = document.querySelectorAll('.hapus');
            qty = document.querySelectorAll('.qty');
            diskon = document.querySelectorAll('.diskon');
            diskonRp = document.querySelectorAll('.diskon-rp');
            hargaDiskon = document.querySelectorAll('.harga-diskon');
            total = document.querySelectorAll('.total');
            setNo()

            reqObj.barangs.splice(i, 1)
        }

        diskonEl.addEventListener('input', e => {
            calcTotal()
            reqObj.diskon = parseInt(e.target.value)
        })

        ongkirEl.addEventListener('input', e => {
            calcTotal()
            reqObj.ongkir = parseInt(e.target.value)
        })



        tambahBarangEl.addEventListener('click', e => {

            const barang = JSON.parse(barangEl.value)

            reqObj.barangs.push({
                ...barang,
                harga: parseInt(barang.harga),
                id: parseInt(barang.id),
                diskon_nilai: 0,
                diskon_pct: 0,
                harga_diskon: parseInt(barang.harga),
                total: parseInt(barang.harga),
                qty: 1
            })

            const htmlEl = `<tr id="item-barang-${barang.id}" class="item-barang">
                            <td><button class="btn btn-danger hapus" id="hapus-${barang.id}">Hapus</button></td>
                            <td class="item-no">1</td>
                            <td>${barang.kode}</td>
                            <td>${barang.nama}</td>
                            <td><input type="number" min="1" class="form-control qty" id="qty-${barang.id}" value="1"></td>
                            <td>${barang.harga}</td>
                            <td><input value="0" max="100" type="number" min="0" class="form-control diskon" id="diskon-${barang.id}" ></td>
                            <td id="diskon-rp-${barang.id}" class="diskon-rp">-</td>
                            <td id="harga-diskon-${barang.id}" class="harga-diskon">200000</td>
                            <td id="total-${barang.id}" class="total">200000</td>
                        </tr>`
            tabelBarangEl.insertAdjacentHTML('beforeend', htmlEl)
            itemBarangEl = document.querySelectorAll('.item-barang');
            itemNo = document.querySelectorAll('.item-no');
            hapus = document.querySelectorAll('.hapus');
            qty = document.querySelectorAll('.qty');
            diskon = document.querySelectorAll('.diskon');
            diskonRp = document.querySelectorAll('.diskon-rp');
            hargaDiskon = document.querySelectorAll('.harga-diskon');
            total = document.querySelectorAll('.total');

            qty.forEach((e, i) => e.addEventListener("input", e => {
                total[i].textContent = parseInt(hargaDiskon[i].innerText) * parseInt(qty[i].value)
                reqObj.barangs[i].total = parseInt(total[i].textContent)
                reqObj.barangs[i].qty = parseInt(e.target.value)
                calcTotal()
            }))

            diskon.forEach((e, i) => e.addEventListener("input", e => {
                diskonRp[i].textContent = parseInt(diskon[i].value) * barang.harga / 100;
                hargaDiskon[i].textContent = barang.harga - parseInt(diskonRp[i].textContent)
                total[i].textContent = parseInt(hargaDiskon[i].innerText) * parseInt(qty[i].value)

                reqObj.barangs[i].diskon_pct = parseInt(e.target.value)
                reqObj.barangs[i].diskon_nilai = parseInt(diskonRp[i].textContent)
                reqObj.barangs[i].harga_diskon = parseInt(hargaDiskon[i].textContent)
                reqObj.barangs[i].total = parseInt(total[i].textContent)
                calcTotal()
            }))

            hapus.forEach((e, i) => e.removeEventListener("click", (e) => {
                hapusListener(e, i)
            }))
            hapus.forEach((e, i) => e.addEventListener("click", (e) => {
                hapusListener(e, i)
            }))

            calcTotal()
            setNo()

        })
    </script>
</body>

</html>
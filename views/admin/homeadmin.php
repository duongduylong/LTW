<?php
require_once _DIR_ROOT . '\views\header.php';
if ($_SESSION['login']['role'] != 4) {
    header('location: home');
}
?>
<div class="section-one">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 ">

                <?php
                require "narbaradmin.php";
                ?>
            </div>
            <div class="col-xl-10 justify-content-center">

                <div class="suscribe-area animate__animated animate__fadeInDown "
                    style="display:block;margin: 5px 0px; border-radius: 10px;  ">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="suscribe-text text-center">
                                    <h4 class="animate__animated animate__fadeInDown"> Danh sách tiêu biểu</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="#" role="form" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-xs-9">
                            <select class="form-control" name="top3">

                                <option value="1" id="1">Sinh viên đăng ký nhiều nhất</option>

                                <option value="3" id="3">Giảng viên dạy nhiều lớp nhất</option>

                                <option value="2" id="2">Trợ giảng nhiều lớp nhất</option>

                            </select>
                        </div>
                    </div>
                </form>
                <table id="tableid"
                    class="table table-hover table-bordered table-responsive animate__animated animate__fadeInUp">
                    <thead class="thead-light">
                        <tr>

                            <th class="text-center align-middle"
                                style="width: 5%;background-color: #3ec1d5; color:#fff">TOP</th>
                            <th class="text-center align-middle"
                                style="width: 3%;background-color: #3ec1d5; color:#fff">Mã định danh</th>
                            <th class="text-center align-middle"
                                style="width: 10%;background-color: #3ec1d5; color:#fff">Họ và tên</th>
                            <th class="text-center align-middle"
                                style="width: 5%;background-color: #3ec1d5; color:#fff">Số môn đăng ký</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $ok = 1;
                        foreach ($data as $key => $li) {
                            if (!is_null($li) && $ok <= 3) {
                                echo '<tr id="' . $li[0]->getUserId() . '">';
                                echo '<td class="text-center align-middle">' . $ok . '</td>';
                                echo '<td class="text-center align-middle">' . $li[0]->getUserName() . '</td>';
                                echo '<td class="text-center align-middle">' . $li[0]->getFullName() . '</td>';
                                echo '<td class="text-center align-middle">' . $li[1] . '</td>';
                                echo '</tr>';
                                $ok += 1;
                            }
                        }
                        ?>
                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>

<script>
    const selectElement = document.querySelector('select[name="top3"]');

    selectElement.addEventListener('change', function (event) {
        const selectedOption = event.target.value;
        $.ajax({
            url: "http://localhost/BT3-WEB/views/admin/selecthome.php",
            method: "POST",
            data: { selectedOption: selectedOption },
            success: function (data) {
                data = JSON.parse(data);
                const table = document.getElementById('tableid');
                const tableBody = document.createElement('tbody');
                var ok = 1;
                for (const key of data) {
                    const dataRow = document.createElement('tr');
                    const dataCells = [
                        ok,
                        key.username,
                        key.fullname,
                        key.num,
                    ];

                    for (const data of dataCells) {
                        const dataCell = document.createElement('td');
                        dataCell.textContent = data;
                        dataCell.className = "text-center align-middle r-10";
                        dataRow.appendChild(dataCell);
                    }
                    tableBody.appendChild(dataRow);
                    ok++;
                }
                const existingBody = table.querySelector('tbody');
                if (existingBody) existingBody.parentNode.removeChild(existingBody);
                table.appendChild(tableBody);
                $("tableid").html(table);
            }
        });

    });
</script>
<?php
require_once _DIR_ROOT . '\views\footer.php';
?>
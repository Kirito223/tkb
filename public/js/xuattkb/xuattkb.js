import { baseURl } from "../api/api.js";
import xuattkbapi from "../api/xuattkbapi.js";
import { getFistDay, getLastDay } from "../ultils/Ultils.js";

var listTeacherBody,
    xuattkbtongquat,
    xuattkblop,
    xuattkbgiaovien,
    xuattkbphancongcm,
    xuattkbphong,
    xuattkb,
    sendEmail,
    monthSelect,
    weekSelect,
    btnAttachFile,
    fileInput,
    listFileAttach,
    progressExport,
    tableList,
    selectAll,
    titleColumn,
    bodyTableList,
    xuattkbdiemtruong,
    kieu,
    tendaydu,
    tenviettat,
    selectweek;

var arrFile = [];
var arrFileAttack = null;

window.onload = function () {
    initControl();
    initData();
    initEvent();
};

function initControl() {
    xuattkbtongquat = document.getElementById("xuattkbtongquat");
    xuattkblop = document.getElementById("xuattkblop");
    xuattkbgiaovien = document.getElementById("xuattkbgiaovien");
    xuattkbphancongcm = document.getElementById("xuattkbphancongcm");
    xuattkbphong = document.getElementById("xuattkbphong");
    xuattkb = document.getElementById("xuattkb");
    monthSelect = document.getElementById("monthSelect");
    weekSelect = document.getElementById("weekSelect");
    btnAttachFile = document.getElementById("btnAttachFile");
    fileInput = document.getElementById("fileInput");
    listFileAttach = document.getElementById("listFileAttach");
    progressExport = document.getElementById("progressExport");
    tableList = document.getElementById("tableList");
    selectAll = document.getElementById("selectAll");
    titleColumn = document.getElementById("titleColumn");
    bodyTableList = document.getElementById("bodyTableList");
    xuattkbdiemtruong = document.getElementById("xuattkbdiemtruong");
    kieu = document.getElementById("kieu");
    tendaydu = document.getElementById("tendaydu");
    tenviettat = document.getElementById("tenviettat");
    selectweek = document.getElementById("selectweek");

    const now = new Date();
    $("#dateprocess").dxDateBox({
        type: "date",
        max: now,
        min: new Date(1900, 0, 1),
        value: now,
    });
    sendEmail = document.getElementById("sendEmail");

    $("#selectmonth").datepicker({
        format: "mm/yyyy",
        orientation: "bottom",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        language: "vi",
    });
}

async function initListTeacher() {
    let listTeacher = await xuattkbapi.getListTeacher();
    $("#dsgiaovienguimail").dxDataGrid({
        dataSource: listTeacher,
        selection: {
            mode: "multiple",
            allowSelectAll: true,
        },
        columns: [
            { dataField: "hovaten", caption: "Tên giáo viên" },
            { dataField: "email", caption: "email" },
        ],
    });
}

function initData() {
    initListTeacher();

    for (let month = 1; month < 13; month++) {
        $("#monthSelect").append(`<option value=${month}>${month}</option>`);
    }
    for (let week = 1; week < 55; week++) {
        $("#weekSelect").append(`<option value=${week}>${week}</option>`);
    }
}

async function loadTeacher() {
    let result = await xuattkbapi.getListTeacher();
    showTable(result);
}

async function loadRoom() {
    let result = await xuattkbapi.getListRoom();
    showTable(result);
}

async function loadLocation() {
    let result = await xuattkbapi.getListLocation();
    showTable(result);
}

async function loadClass() {
    let result = await xuattkbapi.getListClass();
    showTable(result);
}

function showTable(data) {
    let html = "";
    data.forEach((item) => {
        html += `<tr>
        <td><input type="checkbox" class="chkSelect" value="${item.id}" data-name="${item.name}" /></td>
        <td>${item.name}</td>
        </tr>`;
    });
    bodyTableList.innerHTML = html;
}

function reset() {
    kieu.classList.add("hidden");
    tendaydu.checked = false;
    tenviettat.checked = false;
}

function initEvent() {
    selectAll.onclick = function () {
        let chk = document.getElementsByClassName("chkSelect");
        for (const chkSelect of chk) {
            chkSelect.checked = selectAll.checked;
        }
    };

    xuattkbgiaovien.onclick = function (e) {
        reset();

        tableList.classList.remove("hidden");
        titleColumn.textContent = "Tên giáo viên";
        loadTeacher();
    };
    xuattkblop.onclick = function () {
        reset();
        tableList.classList.remove("hidden");
        titleColumn.textContent = "Lớp";
        loadClass();
    };
    xuattkbphong.onclick = function () {
        reset();
        loadRoom();
        tableList.classList.remove("hidden");
    };
    xuattkbtongquat.onclick = function () {
        kieu.classList.remove("hidden");
        tableList.classList.add("hidden");
    };
    xuattkbphancongcm.onclick = function () {
        reset();
        tableList.classList.add("hidden");
    };
    xuattkbdiemtruong.onclick = function () {
        reset();
        loadLocation();
        tableList.classList.remove("hidden");
    };
    fileInput.onchange = function (e) {
        let file = fileInput.files;
        for (const f of file) {
            let li = document.createElement("li");
            li.textContent = f.name;
            listFileAttach.appendChild(li);
        }
    };

    btnAttachFile.onclick = function (e) {
        fileInput.click();
    };

    sendEmail.onclick = function (e) {
        let emailSelect = $("#dsgiaovienguimails")
            .dxDataGrid("instance")
            .getSelectedRowsData();
        let email = emailSelect.map((e) => {
            return e.email;
        });
        sendMail(email);
        // console.log(email);
    };
    xuattkb.onclick = function (e) {
        downLoadTKBEvent();
    };
}

async function downLoadTKBEvent() {
    await exportExcel();
    await downloadTkb();
}

async function sendMail(listMail) {
    let mailFormData = new FormData();
    mailFormData.append("listMail", JSON.stringify(listMail));
    for (var i = 0; i < fileInput.files.length; i++) {
        let file = fileInput.files[i];
        mailFormData.append(`files[${i}]`, file);
    }

    if (listMail.length == 0) {
        Swal.fire(
            "Chưa chọn danh sách giáo viên muốn gửi",
            "Chọn danh sách giáo viên",
            "warning"
        );
    } else {
        let result = await xuattkbapi.sendEmail(mailFormData);
        if (result.msg == "OK") {
            Swal.fire(
                "Đã gửi email thành công",
                "Hoàn tất gửi mail! Số email gửi không thành công: " +
                    result.fail.length,
                "success"
            );
        }
    }
}

async function exportExcel() {
    let tkbtruong = 0,
        tkblop = 0,
        tkbGV = 0,
        tkbphong = 0,
        tkbdiemtruong = 0,
        tkbphancongcm = 0;

    if (xuattkbtongquat.checked == true) {
        tkbtruong = 1;
        arrFile.push("thoikhoabieutruong");
    }
    if (xuattkblop.checked) {
        tkblop = 1;
        arrFile.push("tkblophoc");
    }
    if (xuattkbgiaovien.checked) {
        tkbGV = 1;
        arrFile.push("tkbgiaovien");
    }
    if (xuattkbphancongcm.checked) {
        tkbphancongcm = 1;
        arrFile.push("tkbpccm");
    }
    if (xuattkbphong.checked) {
        tkbphong = 1;
    }
    if (xuattkbdiemtruong.checked) {
        tkbdiemtruong = 1;
    }
    try {
        progressExport.classList.remove("hidden");
        let arrSelect = [];

        if (!tableList.classList.contains("hidden")) {
            if (
                xuattkbgiaovien.checked ||
                xuattkblop.checked ||
                xuattkbphong.checked ||
                xuattkbdiemtruong.checked
            ) {
                let chkSelect = document.querySelectorAll(".chkSelect:checked");
                for (const chk of chkSelect) {
                    arrSelect.push({ id: chk.value, name: chk.dataset.name });
                }
            }
        }

        let monthSelect = $("#selectmonth").val();

        monthSelect = monthSelect.split("/");

        let firstDay = new Date(
            Number(monthSelect[1]),
            Number(monthSelect[0]) - 1,
            1
        );
        var lastDay = new Date(
            Number(monthSelect[1]),
            Number(monthSelect[0]),
            0
        );

        firstDay = moment(firstDay).format("YYYY/MM/DD");
        lastDay = moment(lastDay).format("YYYY/MM/DD");

        if (firstDay == "Invalid date" && lastDay == "Invalid date") {
            progressExport.setAttribute("aria-valuenow", "100");
            progressExport.classList.add("hidden");
            Swal.fire(
                "Xin vui lòng chọn thời gian muốn xuất",
                "Chọn thời gian xuất",
                "warning"
            );
        } else {
            let result = await xuattkbapi.export(
                JSON.stringify({
                    tkbtruong: tkbtruong,
                    tkblop: tkblop,
                    tkbGV: tkbGV,
                    tkbphong: tkbphong,
                    tkbdiemtruong: tkbdiemtruong,
                    tkbphancongcm: tkbphancongcm,
                    arrSelect: JSON.stringify(arrSelect),
                    exportAll: selectAll.checked,
                    tendaydu: tendaydu.checked,
                    tenviettat: tenviettat.checked,
                    startMonth: firstDay,
                    endMonth: lastDay,
                    week: selectweek.value,
                })
            );

            if (
                xuattkbphong.checked == true ||
                xuattkbdiemtruong.checked == true
            ) {
                arrFile.length = 0;

                result.data.forEach((item) => {
                    let isset = arrFile.findIndex((x) => x == item);
                    if (isset == -1) {
                        arrFile.push(item);
                    }
                });
            }
            progressExport.setAttribute("aria-valuenow", "100");
            progressExport.classList.add("hidden");
        }
    } catch (error) {
        console.log(error);
        progressExport.setAttribute("aria-valuenow", "100");
        progressExport.classList.add("hidden");
        Swal.fire("Đã có lỗi xảy ra vui lòng thử lại sau", "Lỗi", "error");
    }
}

function downloadTkb() {
    arrFile.forEach((file) => {
        window.open(`${baseURl}xuattkb/export/${file}.xlsx`);
    });
    arrFile.length = 0;
}

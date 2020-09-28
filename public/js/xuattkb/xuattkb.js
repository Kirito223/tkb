import { baseURl } from "../api/api.js";
import xuattkbapi from "../api/xuattkbapi.js";

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
    listFileAttach;

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

    const now = new Date();
    $("#dateprocess").dxDateBox({
        type: "date",
        max: now,
        min: new Date(1900, 0, 1),
        value: now,
    });
    sendEmail = document.getElementById("sendEmail");
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
            { dataField: "email", caption: "Tên giáo viên" },
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

function initEvent() {
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
        let emailSelect = $("#dsgiaovienguimail")
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
        arrFile.push("tkblophoc");
        tkbphong = 1;
    }

    let result = await xuattkbapi.export(
        JSON.stringify({
            tkbtruong: tkbtruong,
            tkblop: tkblop,
            tkbGV: tkbGV,
            tkbphong: tkbphong,
            tkbphancongcm: tkbphancongcm,
            // date: date,
        })
    );
}

function downloadTkb() {
    arrFile.forEach((file) => {
        window.open(`${baseURl}xuattkb/export/${file}.xlsx`);
    });
    arrFile.length = 0;
}

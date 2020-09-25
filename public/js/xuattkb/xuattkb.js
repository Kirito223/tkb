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
    weekSelect;

var arrFile = [];
var arrFileAttack = [];
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
    let result = await xuattkbapi.sendEmail({
        listMail: listMail,
        fileAttack: arrFileAttack,
        week: weekSelect.value,
        month: monthSelect.value,
    });
    if (result.msg == "OK") {
        Swal.fire(
            "Đã gửi email thành công",
            "Hoàn tất gửi mail! Số email gửi không thành công: " +
                result.fail.length,
            "success"
        );
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
        arrFile.push("tkblop");
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
    arrFileAttack.length = 0;
    arrFile.forEach((file) => {
        window.open(`${baseURl}xuattkb/export/${file}.xlsx`);
        arrFileAttack.push(file);
    });
    arrFile.length = 0;
}

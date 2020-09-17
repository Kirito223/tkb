import sotiettoidaBuoiApi from "../rangbuoc/api/sotiettoidaBuoi.js";
var chonmonhocBuoi,
sotiettoidaBuoi,
apdungtoantruongBuoi,
dongyBuoi,
showLopApDungBuoi,
headDanhSachLopBuoi,
bodyDanhSachLopBuoi,
capnhatBuoi,
monhocBuoi,
tableDanhsachPhanTietBuoi,
tongsotietBuoi,
tableChuaphancongBuoi,
bangphantiet,
dataPhantiet;

var danhsachmonhoc, danhsachkhoihoc;
window.onload = function () {
    initControl();
    initData();
    initEvent();
};

function initControl() {
    chonmonhocBuoi = document.getElementById("chonmonhocBuoi");
    apdungtoantruongBuoi = document.getElementById("apdungtoantruongBuoi");
    dongyBuoi = document.getElementById("dongyBuoi");
    showLopApDungBuoi = document.getElementById("showLopApDungBuoi");
    headDanhSachLopBuoi = document.getElementById("headDanhSachLopBuoi");
    bodyDanhSachLopBuoi = document.getElementById("bodyDanhSachLopBuoi");
    capnhatBuoi = document.getElementById("capnhatBuoi");
    monhocBuoi = document.getElementById("monhocBuoi");
    tableDanhsachPhanTietBuoi = document.getElementById(
        "tableDanhsachPhanTietBuoi"
        );
    tongsotietBuoi = document.getElementById("tongsotietBuoi");
    sotiettoidaBuoi = document.getElementById("sotiettoidaBuoi");
    bangphantiet = document.getElementById("bangphantiet");
    tableChuaphancongBuoi = document.getElementById("tableChuaphancongBuoi");
}

async function initData() {
    let data = await sotiettoidaBuoiApi.getDuLieu();
    danhsachkhoihoc = data.khoihoc;
    danhsachmonhoc = data.monhoc;
    dataPhantiet = data.bangphantiet;
    renderTableKhoi();
    renderTablePhanTiet();
    renderMonhoc();
    setData(dataPhantiet);
}

function initEvent() {
    showLopApDungBuoi.onclick = function (e) {
        if (tableChuaphancongBuoi.classList.contains("hidden")) {
            showLopApDungBuoi.classList.remove("fa-arrow-circle-right");
            showLopApDungBuoi.classList.add("fa-arrow-circle-down");
            tableChuaphancongBuoi.classList.remove("hidden");
        } else {
            showLopApDungBuoi.classList.remove("fa-arrow-circle-down");
            showLopApDungBuoi.classList.add("fa-arrow-circle-right");
            tableChuaphancongBuoi.classList.add("hidden");
        }
    };
    apdungtoantruongBuoi.onclick = function (e) {
        let inputCheckbox = document.querySelectorAll('input[type="checkbox"]');
        for (const chk of inputCheckbox) {
            chk.checked = apdungtoantruongBuoi.checked;
        }
    };

    capnhatBuoi.onclick = function (e) {
        saveDataBuoi();
    };

    dongyBuoi.onclick = function (e) {
        let mon = chonmonhocBuoi.value;
        let sotiet = sotiettoidaBuoi.value;
        let listClassSelect = document.querySelectorAll(".classRoom:checked");

// clear all value in input
let phonghocClear = document.querySelectorAll(
    `.sotiet[data-monhocbuoi="${mon}"]`
    );
for (const clears of phonghocClear) {
    clears.value = "";
}

for (const cls of listClassSelect) {
    let phonghoc = document.querySelector(
        `.sotiet[data-lophocbuoi="${cls.value}"][data-monhocbuoi="${mon}"]`
        );
    phonghoc.value = sotiet;
}
};
}

function setData(data) {
    data.forEach((item) => {
        let input = document.querySelector(
            `.sotiet[data-lophocbuoi="${item.lophoc}"][data-monhocbuoi="${item.monhoc}"]`
            );
        input.value = item.sotiet;
    });
}

function renderMonhoc() {
    danhsachmonhoc.map((item) => {
        let option = document.createElement("option");
        option.value = item.id;
        option.textContent = item.tenmonhoc;
        chonmonhocBuoi.appendChild(option);
    });
}
async function saveDataBuoi() {
    let danhsachPhantiet = document.getElementsByClassName("sotiet");
    let data = [];
    for (const item of danhsachPhantiet) {
        if (item.value != "") {
            data.push({
                lophoc: item.dataset.lophocbuoi,
                monhoc: item.dataset.monhocbuoi,
                sotiet: item.value,
            });
        }
    }
    const result = await sotiettoidaBuoiApi.saveDulieu(JSON.stringify(data));
    if (result["msg"] == "OK") {
        Swal.fire("Cập nhật thành công", "Đã cập nhật dữ liệu", "success");
    } else {
        Swal.fire(
            "Cập nhật không thành công",
            "Đã xảy ra lỗi vui lòng kiểm tra lại",
            "error"
            );
    }
}
function renderTablePhanTiet() {
    danhsachmonhoc.map((item) => {
        let th = document.createElement("th");

        let text = document.createTextNode(item.tenmonhoc);
        th.appendChild(text);
        monhocBuoi.appendChild(th);
    });
    tongsotietBuoi.colSpan = danhsachmonhoc.length;
    let sott = 1;

    for (const iterator of danhsachkhoihoc) {
        let danhsach = iterator.danhsachlop;
        for (const lop of danhsach) {
            let tr = document.createElement("tr");

            let tdStt = document.createElement("td");
            tdStt.textContent = sott;

            let tdTenlop = document.createElement("td");
            tdTenlop.textContent = lop.tenlop;

            tr.appendChild(tdStt);
            tr.appendChild(tdTenlop);

// render mon hoc
for (const iterator of danhsachmonhoc) {
    let tdmon = document.createElement("td");

    let input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("data-monhocbuoi", iterator.id);
    input.setAttribute("data-lophocbuoi", lop.id);
    input.setAttribute("class", "sotiet");
    input.style.width = "60px";

    tdmon.appendChild(input);
    tr.appendChild(tdmon);
}

tableDanhsachPhanTietBuoi.appendChild(tr);
sott++;
}
}
}

function renderTableKhoi() {
// Tim khoi lop co nhieu lop nhat
let max = 0;
for (const iterator of danhsachkhoihoc) {
    if (iterator.danhsachlop.length > max) {
        max = iterator.danhsachlop.length;
    }
}
// Render Header truoc
for (const iterator of danhsachkhoihoc) {
    var chkbox = document.createElement("input");
    chkbox.setAttribute("type", "checkbox");
    chkbox.setAttribute("id", iterator.makhoi);
    chkbox.setAttribute("data-khoibuoi", iterator.makhoi);
    chkbox.onclick = function (e) {
        let chkClass = document.querySelectorAll(
            `.classRoom[data-khoibuoi="${e.target.dataset.khoibuoi}"]`
            );

        for (const classRoom of chkClass) {
            classRoom.checked = e.target.checked;
        }
    };

    var text = document.createTextNode(" " + iterator.tenkhoi);
    let th = document.createElement("th");

    let span = document.createElement("span");
    span.appendChild(chkbox);
    span.appendChild(text);
    th.appendChild(span);
    headDanhSachLopBuoi.appendChild(th);
}
// hien thi cac lop hoc
for (let position = 0; position < max; position++) {
    let tr = document.createElement("tr");
    for (const iterator of danhsachkhoihoc) {
        let td = document.createElement("td");
        if (iterator.danhsachlop[position] != undefined) {
            var chkbox = document.createElement("input");
            chkbox.setAttribute("type", "checkbox");
            chkbox.setAttribute("class", "classRoom");
            chkbox.value = iterator.danhsachlop[position].id;
            chkbox.setAttribute(
                "data-khoibuoi",
                iterator.danhsachlop[position].khoi
                );
            var text = document.createTextNode(
                " " + iterator.danhsachlop[position].tenlop
                );
            td.appendChild(chkbox);
            td.setAttribute("class", "lophoc");
            td.appendChild(text);
            tr.appendChild(td);
        } else {
            tr.appendChild(td);
        }
    }
    bodyDanhSachLopBuoi.appendChild(tr);
}
}
import {
    danhsachPhancong,
    luuPhancong,
    xoaToanboPhancongcuaGiaovien,
    xoaToanboPhancongcuaMonhoc,
    xuatBangphancong,
} from "../api/phancongGVApi.js";
import phanconggv from "../model/phanconggv.js";
import http from "../const/http.js";
import { public_path } from "../const/path.js";
var bangPhancong = [];

var danhsachphancong;
var danhsachGiaovien;
var danhsachmonhoc;
var danhsachLop;
var sotietmon;

var bangdanhsachphancongchomonhoc;

var bangdanhsachphancong,
    bangdanhsachmonpc,
    btncapnhatpccmgiaovien,
    lblPhacong,
    lblTongsotiet,
    trDanhsachmonhoc,
    thMonhoc,
    bangSotietchuaphancongs,
    tongsotietcp,
    showchitietchuapc,
    tableChuaphancong,
    btnXoatatcaPCCMtaimon,
    btnTaipccm,
    timkiemhovaten,
    timkiemTen,
    timkiemBidanh,
    chontatcaphancongmon;

var mondachon = [];
var lopdachon = [];
var bangphancongTam = [];
var xoaPhancong = [];
var giaovienchon;
var arrSuaSotiet = [];

window.onload = function () {
    initControl();
    document.getElementById("phancong_giaovienday").onclick = function () {
        resetData();
        initData();
        initEvent();
    };
};

function resetData() {
    danhsachphancong = null;
    danhsachGiaovien = null;
    danhsachmonhoc = null;
    danhsachLop = null;
    sotietmon = null;
    bangphancongTam.length = 0;
}

function initControl() {
    bangdanhsachphancong = document.getElementById("bangdanhsachphancong");
    bangdanhsachmonpc = document.getElementById("bangdanhsachmonpc");
    bangdanhsachphancongchomonhoc = document.getElementById(
        "bangdanhsachphancongchomonhoc"
    );
    btncapnhatpccmgiaovien = document.getElementById("btncapnhatpccmgiaovien");
    lblPhacong = document.getElementById("lblPhacong");
    lblTongsotiet = document.getElementById("lblTongsotiet");
    trDanhsachmonhoc = document.getElementById("trDanhsachmonhoc");
    thMonhoc = document.getElementById("thMonhoc");
    bangSotietchuaphancongs = document.getElementById(
        "bangSotietchuaphancongs"
    );
    tongsotietcp = document.getElementById("tongsotietcp");
    // fshowchitietchuapc = document.getElementById("showchitietchuapc");
    tableChuaphancong = document.getElementById("tableChuaphancong");
    btnXoatatcaPCCMtaimon = document.getElementById("btnXoatatcaPCCMtaimon");
    btnTaipccm = document.getElementById("btnTaipccm");
    timkiemhovaten = document.getElementById("timkiemhovaten");
    // timkiemTen = document.getElementById("timkiemTen");
    timkiemBidanh = document.getElementById("timkiemBidanh");
    chontatcaphancongmon = document.getElementById("chontatcaphancongmon");
}

async function initData() {
    await laydanhsach();
}
function Search(tdClass, searchTxt) {
    let td = document.getElementsByClassName(tdClass);
    let textSearch = searchTxt.value.toUpperCase();
    for (const item of td) {
        let tdValue = item.textContent || item.innerText;
        if (tdValue.toUpperCase().indexOf(textSearch) > -1) {
            item.parentElement.style.display = "";
        } else {
            item.parentElement.style.display = "none";
        }
    }
}

function initEvent() {
    chontatcaphancongmon.onclick = function (e) {
        let chk = document.querySelectorAll(".chkChonlop");
        let chkChecked = document.querySelectorAll(".chkChonlop:checked");

        let arrChecked = [];
        for (const checked of chkChecked) {
            arrChecked.push(checked.value);
        }

        if (e.target.checked == true) {
            for (const item of chk) {
                let index = arrChecked.findIndex((x) => x == item.value);
                if (index == -1) {
                    item.click();
                }
            }
        } else {
            for (const item of chk) {
                item.click();
            }
        }
    };

    timkiemhovaten.oninput = function (e) {
        Search("tdhovaten", timkiemhovaten);
    };

    timkiemBidanh.oninput = function (e) {
        Search("tdBidanh", timkiemBidanh);
    };

    btnXoatatcaPCCMtaimon.onclick = function (e) {
        let idMon = Number(btnXoatatcaPCCMtaimon.dataset.id);
        let giaovien = Number(btnXoatatcaPCCMtaimon.dataset.giaovien);
        if (idMon != "") {
            xoaToanboPhancongcuaMonhoc(idMon, giaovien).then((res) => {
                if (res.code == 200) {
                    window.location.reload();
                } else {
                    Swal.fire(
                        "Đã có lỗi xảy ra vui lòng thử lại sau",
                        "Đã có lỗi xảy ra",
                        "error"
                    );
                }
            });
        } else {
            Swal.fire(
                "Chưa chọn phân môn để xóa",
                "Hãy chọn phân môn muốn xóa",
                "warning"
            );
        }
    };

    btncapnhatpccmgiaovien.onclick = function (e) {
        // Cap nhat thong tin phan cong chuyen mon cho giao vien
        luuPhancong(
            bangphancongTam,
            giaovienchon,
            xoaPhancong,
            arrSuaSotiet
        ).then((res) => {
            if (res["code"] == http.CODE_SUCCESS) {
                window.location.reload();
            } else {
                Swal.fire(
                    "Đã có lỗi xảy ra vui lòng thử lại sau",
                    "Cập nhật phân công chuyên môn không thành công",
                    "success"
                );
            }
        });
    };
}

async function laydanhsach() {
    let danhsach = await danhsachPhancong();
    // Tong hop du lieu
    danhsachphancong = danhsach.danhsachphancong;
    danhsachGiaovien = danhsach.danhsachGiaovien;
    danhsachmonhoc = danhsach.danhsachmonhoc;
    danhsachLop = danhsach.danhsachlop;
    sotietmon = danhsach.sotietmonhoc;
    // Đổ dữ liệu vào danh sách tạm

    danhsachphancong.map((item) => {
        bangphancongTam.push({
            magiaovien: item.magiaovien,
            mamonhoc: item.mamonhoc,
            sotiet: item.sotiet,
            malop: item.malop,
        });
    });

    danhsachGiaovien.forEach((gv) => {
        let phancong = new phanconggv();
        phancong.magiaovien = gv.id;
        phancong.hovaten = gv.hovaten;
        phancong.bidanh = gv.bidanh;

        // lay danh sach nhung phan mon duoc phan cong
        let phancongs = danhsachphancong.filter((x) => x.magiaovien == gv.id);

        // Thong ke theo danh sach da phan cong cho giao vien

        let pcmon = [];
        phancongs.forEach((pc) => {
            let mon = danhsachmonhoc.findIndex((x) => x.id == pc.mamonhoc);
            let lop = danhsachLop.findIndex((x) => x.id == pc.malop);
            pcmon.push({
                mammon: pc.mamonhoc,
                tenmon: mon.tenmonhoc,
                malop: pc.malop,
                tenlop: lop.tenlop,
                sotiet: pc.sotiet,
            });
        });
        phancong.danhsachphanmon = pcmon;
        bangPhancong.push(phancong);
    });
    hienthiDanhsach(bangPhancong);
}

function hienthiDanhsach(danhsach) {
    bangdanhsachphancong.innerHTML = "";
    let index = 1;
    danhsach.forEach((item) => {
        let tr = document.createElement("tr");
        let stt = creatTd(index);
        let hovaten = creatTd(item.hovaten, null, "tdhovaten");
        let bidanh = creatTd(item.bidanh, null, "tdBidanh");

        let chuyenmon = document.createElement("td");
        chuyenmon.setAttribute("class", "chuyenmongv");
        chuyenmon.setAttribute("data-giaovien", item.magiaovien);
        let chuyenMontext = document.createTextNode("");
        chuyenmon.appendChild(chuyenMontext);
        // hien thi danh sach phan mon
        let danhsachphanmon = item.danhsachphanmon;
        let arrChuyenmon = [];
        danhsachphanmon.forEach((mon) => {
            let check = arrChuyenmon.findIndex((x) => x.mammon == mon.mammon);
            if (check == -1) {
                let index = danhsachmonhoc.findIndex((x) => x.id == mon.mammon);
                arrChuyenmon.push(danhsachmonhoc[index]);
            }
        });
        // Hien thi danh sach chuyen mon
        hienThiChuyenMon(arrChuyenmon, chuyenmon);

        // Hien thi tong so tiet day
        let sotiet = document.createElement("td");
        sotiet.setAttribute("class", "tongsotietgv");
        sotiet.setAttribute("data-giaovien", item.magiaovien);
        let sotiettext = document.createTextNode("");
        sotiet.appendChild(sotiettext);
        hienthitongsotietGiaovien(danhsachphanmon, sotiet);

        let buttonPCCM = document.createElement("button");
        buttonPCCM.setAttribute("class", "btn btn-sm btn-info");
        buttonPCCM.setAttribute(`data-id`, item.magiaovien);
        let lbl = document.createTextNode("PCCM");
        buttonPCCM.appendChild(lbl);

        // Su kien click cua nut phan cong chuyen mon

        buttonPCCM.onclick = function (e) {
            bangdanhsachmonpc.innerHTML = "";
            bangdanhsachphancongchomonhoc.innerHTML = "";
            let id = buttonPCCM.dataset.id;

            let indexGiaovien = danhsachGiaovien.findIndex((x) => x.id == id);
            let ttgiaovien = danhsachGiaovien[indexGiaovien];
            giaovienchon = ttgiaovien.id;
            btncapnhatpccmgiaovien.textContent = `Phân công chuyên môn cho giáo viên: ${ttgiaovien.hovaten}`;
            lblPhacong.textContent = `Phân công chuyên môn cho giáo viên: ${ttgiaovien.hovaten}`;

            hienthiTongsotiet(giaovienchon);
            // Hien thi danh sach cac lop hoc cung nhu cac giao vien duoc phan cong giang day bo mon dang duoc chon

            let index = 1;
            danhsachmonhoc.forEach((item) => {
                let tr = document.createElement("tr");

                let stt = creatTd(index);
                let mon = creatTd(item.tenmonhoc);
                // Hien thi o lop day
                let lopday = creatTd("");
                lopday.setAttribute("class", "tdLopdayMon");
                lopday.setAttribute("style", "word-break:break-all");
                lopday.setAttribute("data-lopdayMon", item.id);

                let chon = document.createElement("td");
                // Check box chon mon hoc se duoc phan cong cho giao vien
                let chk = document.createElement("input");
                chk.setAttribute("type", "checkbox");
                chk.setAttribute("value", item.id);
                chk.setAttribute("class", "chkMon");
                chk.setAttribute("data-giaovien", giaovienchon);
                chk.onclick = function (e) {
                    chontatcaphancongmon.setAttribute(
                        "data-giaovien",
                        giaovienchon
                    );
                    // hien danh sach phan cong
                    bangdanhsachphancongchomonhoc.innerHTML = "";

                    if (chk.checked == true) {
                        let idMon = chk.value;
                        mondachon.push(idMon);
                        let monIndex = danhsachmonhoc.findIndex(
                            (x) => x.id == idMon
                        );

                        btnXoatatcaPCCMtaimon.textContent = `Xóa tất cả phân công chuyên môn tại môn: ${danhsachmonhoc[monIndex].tenmonhoc}`;
                        btnXoatatcaPCCMtaimon.dataset.id = idMon;
                        btnXoatatcaPCCMtaimon.dataset.giaovien = ttgiaovien.id;
                        //Bỏ chọn những thằng khác
                        let chkMon = document.getElementsByClassName("chkMon");

                        // Kiem tra xem mon nay da duoc chon de phan cong chua neu roi thi giu nguyen checked con neu chua thi xoa checked da chon

                        for (let item of chkMon) {
                            if (
                                item.value != idMon &&
                                !item.classList.contains("selected")
                            ) {
                                item.checked = false;

                                // go bo khoi mang
                                let index = mondachon.findIndex(
                                    (x) => x == item.value
                                );
                                if (index > -1) {
                                    mondachon.splice(index, 1);
                                }
                            }
                        }

                        // Hien thi danh sach phan cong

                        let sttIndex = 1;
                        // Render danh sach lop de chon phan cong
                        danhsachLop.forEach((item) => {
                            // Tinh so tiet chua duoc phan cong cho mon hoc nay tai lop nay

                            let indexSotiet = sotietmon.findIndex(
                                (x) =>
                                    x.mamonhoc == chk.value &&
                                    x.malop == item.id
                            );

                            let tongphancong = 0;
                            danhsachphancong.filter((pc) => {
                                if (
                                    pc.mamonhoc == chk.value &&
                                    pc.malop == item.id
                                ) {
                                    tongphancong += pc.sotiet;
                                }
                            });
                            let sotiet = 0;
                            let sotietmacdinh = 0;
                            if (indexSotiet > -1) {
                                sotiet =
                                    sotietmon[indexSotiet].sotiet -
                                    tongphancong;
                                sotietmacdinh = sotiet;
                            }

                            let tr = document.createElement("tr");

                            let stt = creatTd(sttIndex);
                            let lop = creatTd(item.tenlop);

                            let sotiettd = document.createElement("td");
                            let inputsotiettd = document.createElement("input");
                            inputsotiettd.setAttribute("data-lop", item.id);
                            inputsotiettd.classList.add("form-control");
                            inputsotiettd.classList.add("inputPhancong");
                            inputsotiettd.setAttribute(
                                "data-monhoc",
                                chk.value
                            );

                            let sotietdaphan = danhsachphancong.find(
                                (x) =>
                                    x.mamonhoc == chk.value &&
                                    x.malop == inputsotiettd.dataset.lop &&
                                    x.magiaovien == ttgiaovien.id
                            );
                            if (sotietdaphan != null) {
                                inputsotiettd.value = sotietdaphan.sotiet;
                            } else {
                                inputsotiettd.value = "";
                            }

                            inputsotiettd.oninput = function (e) {
                                // Kich hoat su kien khi nguoi dung nhap lieu vao o input
                                let idLop = Number(inputsotiettd.dataset.lop);

                                // Tinh lai so tiet sau khi phan cong

                                if (
                                    Number(inputsotiettd.value) > sotietmacdinh
                                ) {
                                    sotietchuaphancong.textContent = sotietmacdinh;
                                    Swal.fire(
                                        "Số tiết phân công không được quá só tiết môn học",
                                        "Vượt quá số tiết",
                                        "warning"
                                    );
                                } else {
                                    if (inputsotiettd.value == "") {
                                        sotietchuaphancong.textContent = sotietmacdinh;
                                        let check = document.querySelector(
                                            `span[data-idgiaovien="${ttgiaovien.id}"]][data-lop="${idLop}"]`
                                        );
                                        if (check != null) {
                                            check.remove();
                                        }
                                    } else {
                                        sotietchuaphancong.textContent =
                                            sotietmacdinh -
                                            Number(inputsotiettd.value);
                                        let check = document.querySelector(
                                            `span[data-idgiaovien="${ttgiaovien.id}"][data-lop="${idLop}"]`
                                        );
                                        if (
                                            check == null &&
                                            inputsotiettd.value != 0
                                        ) {
                                            giaovien.insertAdjacentHTML(
                                                "beforeend",
                                                `<span data-lop="${idLop}" data-idgiaovien="${ttgiaovien.id}">${ttgiaovien.hovaten}</span>`
                                            );
                                        }
                                    }

                                    // Kiem tra va them so tiet vao mang chinh sua so tiet tam

                                    let indexSotietSua = arrSuaSotiet.findIndex(
                                        (x) =>
                                            x.monhoc ==
                                                inputsotiettd.dataset.monhoc &&
                                            x.lophoc == idLop
                                    );

                                    if (indexSotietSua == -1) {
                                        arrSuaSotiet.push({
                                            lophoc: idLop,
                                            monhoc: Number(
                                                inputsotiettd.dataset.monhoc
                                            ),
                                            sotiet: Number(inputsotiettd.value),
                                        });
                                    } else {
                                        arrSuaSotiet[
                                            indexSotietSua
                                        ].sotiet = Number(inputsotiettd.value);
                                    }

                                    let txtSotiet = document.querySelector(
                                        '.txtSotietmon[data-mon="' +
                                            inputsotiettd.dataset.monhoc +
                                            '"]'
                                    );
                                    lopdachon.push(idLop);

                                    let checkPhancong = bangphancongTam.findIndex(
                                        (x) =>
                                            x.magiaovien == ttgiaovien.id &&
                                            x.mamonhoc ==
                                                inputsotiettd.dataset.monhoc &&
                                            x.malop == idLop
                                    );

                                    let checkBangphancong = danhsachphancong.findIndex(
                                        (x) =>
                                            x.mamonhoc ==
                                                inputsotiettd.dataset.monhoc &&
                                            x.malop == idLop &&
                                            x.magiaovien == ttgiaovien.id
                                    );

                                    if (checkPhancong == -1) {
                                        //Them phan cong vao bang phan cong tam
                                        bangphancongTam.push({
                                            magiaovien: ttgiaovien.id,
                                            mamonhoc: Number(
                                                inputsotiettd.dataset.monhoc
                                            ),
                                            sotiet: Number(inputsotiettd.value),
                                            malop: idLop,
                                        });

                                        // Them vao bang phan cong neu chua co
                                        danhsachphancong.push({
                                            id: 0,
                                            magiaovien: ttgiaovien.id,
                                            malop: idLop,
                                            mamonhoc: Number(
                                                inputsotiettd.dataset.monhoc
                                            ),
                                            sotiet: Number(inputsotiettd.value),
                                        });
                                    } else {
                                        // chinh sua lai thong tin trong bang phan cong tam
                                        bangphancongTam.splice(
                                            checkPhancong,
                                            1
                                        );
                                        bangphancongTam.push({
                                            magiaovien: ttgiaovien.id,
                                            mamonhoc: Number(
                                                inputsotiettd.dataset.monhoc
                                            ),
                                            sotiet: Number(inputsotiettd.value),
                                            malop: idLop,
                                        });
                                        danhsachphancong.splice(
                                            checkBangphancong,
                                            1
                                        );
                                        danhsachphancong.push({
                                            id: 0,
                                            magiaovien: ttgiaovien.id,
                                            malop: idLop,
                                            mamonhoc: Number(
                                                inputsotiettd.dataset.monhoc
                                            ),
                                            sotiet: Number(inputsotiettd.value),
                                        });
                                    }

                                    txtSotiet.textContent = tinhTongsotiet(
                                        ttgiaovien.id,
                                        inputsotiettd.dataset.monhoc
                                    );

                                    // sotietchuaphancong.textContent = "";
                                    chk.classList.add("selected");

                                    hienthidanhsachLopday(
                                        ttgiaovien.id,
                                        inputsotiettd.dataset.monhoc
                                    );
                                    hienthiTongsotiet(ttgiaovien.id);
                                }
                            };

                            sotiettd.appendChild(inputsotiettd);

                            let sotietchuaphancong = creatTd(sotiet);

                            let tdChon = document.createElement("td");
                            let inputChon = document.createElement("input");
                            inputChon.setAttribute("type", "checkbox");
                            inputChon.setAttribute("value", item.id);
                            inputChon.setAttribute("class", "chkChonlop");
                            inputChon.setAttribute("data-chon", "khongchon");

                            // Kiem tra mon hoc tai lop da duoc phan cong chua

                            let findGiaovien = danhsachphancong.findIndex(
                                (o) =>
                                    o.malop == item.id &&
                                    o.mamonhoc == chk.value &&
                                    o.magiaovien == ttgiaovien.id
                            );
                            let giaovien;
                            // Nếu có giáo viên đã phân công thì hiển thị tên giáo viên được phân công cũng như vô hiệu hóa nút checkbox
                            if (findGiaovien > -1) {
                                inputChon.checked = true;
                                // Co giao vien day
                                let indexGiaovien = danhsachGiaovien.findIndex(
                                    (x) =>
                                        x.id ==
                                        danhsachphancong[findGiaovien]
                                            .magiaovien
                                );

                                inputChon.setAttribute(
                                    "data-giaovien",
                                    danhsachGiaovien[indexGiaovien].id
                                );
                                inputChon.setAttribute("data-chon", "chon");
                                // Tim tat cac cac giao vien day mon nay tai lop nay

                                giaovien = document.createElement("td");
                                let name = "";
                                danhsachphancong.filter((x) => {
                                    if (
                                        x.mamonhoc == chk.value &&
                                        x.malop == item.id
                                    ) {
                                        let giaovienIndex = danhsachGiaovien.find(
                                            (f) => f.id == x.magiaovien
                                        );
                                        name +=
                                            giaovienIndex.hovaten != null
                                                ? `<span data-lop="${item.id}" data-idgiaovien="${giaovienIndex.id}">${giaovienIndex.hovaten},</span>`
                                                : `<span data-lop="${item.id}" data-idgiaovien="${giaovienIndex.id}">${giaovienIndex.bidanh}</span>`;
                                    }
                                });
                                giaovien.innerHTML = name;
                            } else {
                                giaovien = creatTd("");
                            }

                            // Su kien khi click chon giao phan cong cho giao vien day mon nay

                            inputChon.onclick = function (e) {
                                document.querySelector(
                                    `.inputPhancong[data-lop="${inputChon.value}"][data-monhoc="${chk.value}"]`
                                ).disabled = false;

                                let idLop = inputChon.value;
                                let txtSotiet = document.querySelector(
                                    '.txtSotietmon[data-mon="' +
                                        chk.value +
                                        '"]'
                                );

                                // Kiem tra xem checkbox lop duoc chon xem no co duoc chon hay khong

                                if (inputChon.checked) {
                                    lopdachon.push(idLop);
                                    let check = document.querySelector(
                                        `span[data-idgiaovien="${ttgiaovien.id}"][data-lop="${idLop}"]`
                                    );
                                    if (check == null) {
                                        giaovien.insertAdjacentHTML(
                                            "beforeend",
                                            `<span data-lop="${idLop}" data-idgiaovien="${ttgiaovien.id}">${ttgiaovien.hovaten}</span>`
                                        );
                                    }

                                    // Neu tich chon thi se dat so tiet da chon ve khong

                                    sotietchuaphancong.textContent = 0;
                                    // Tim kiem so tiet duoc phan cho mon hoc cua lop
                                    let checkPhancong = bangphancongTam.findIndex(
                                        (x) =>
                                            x.magiaovien == ttgiaovien.id &&
                                            x.mamonhoc == chk.value &&
                                            x.malop == idLop
                                    );

                                    let checkBangphancong = danhsachphancong.findIndex(
                                        (x) =>
                                            x.mamonhoc == chk.value &&
                                            x.malop == idLop &&
                                            x.magiaovien == ttgiaovien.id
                                    );
                                    if (checkPhancong == -1) {
                                        //Them phan cong vao bang phan cong tam
                                        bangphancongTam.push({
                                            magiaovien: ttgiaovien.id,
                                            mamonhoc: chk.value,
                                            sotiet: sotiet,
                                            malop: idLop,
                                        });

                                        // Them vao bang phan cong neu chua co
                                        danhsachphancong.push({
                                            id: 0,
                                            magiaovien: ttgiaovien.id,
                                            malop: idLop,
                                            mamonhoc: chk.value,
                                            sotiet: sotiet,
                                        });
                                    } else {
                                        // chinh sua lai thong tin trong bang phan cong tam
                                        bangphancongTam.splice(
                                            checkPhancong,
                                            1
                                        );
                                        bangphancongTam.push({
                                            magiaovien: ttgiaovien.id,
                                            mamonhoc: chk.value,
                                            sotiet: sotiet,
                                            malop: idLop,
                                        });
                                        danhsachphancong.splice(
                                            checkBangphancong,
                                            1
                                        );
                                        danhsachphancong.push({
                                            id: 0,
                                            magiaovien: ttgiaovien.id,
                                            malop: idLop,
                                            mamonhoc: chk.value,
                                            sotiet: sotiet,
                                        });
                                    }

                                    txtSotiet.textContent = tinhTongsotiet(
                                        ttgiaovien.id,
                                        chk.value
                                    );
                                    inputsotiettd.value = sotiet;
                                    chk.classList.add("selected");
                                } else {
                                    inputsotiettd.value = 0;
                                    sotietchuaphancong.textContent = sotiet;
                                    // Go bo lop khoi mang
                                    let index = lopdachon.findIndex(
                                        (x) => x == idLop
                                    );
                                    if (index > -1) {
                                        lopdachon.splice(index, 1);
                                        let check = document.querySelector(
                                            `span[data-idgiaovien="${ttgiaovien.id}"][data-lop="${idLop}"]`
                                        );
                                        if (check != null) {
                                            check.remove();
                                        }
                                    }
                                    // Go bo khoi mang tam
                                    let indexPhancong = bangphancongTam.findIndex(
                                        (x) =>
                                            x.magiaovien == ttgiaovien.id &&
                                            x.mamonhoc == chk.value &&
                                            x.malop == inputChon.value
                                    );
                                    if (indexPhancong > -1) {
                                        bangphancongTam.splice(
                                            indexPhancong,
                                            1
                                        );
                                        let tongsotiet = tinhTongsotiet(
                                            ttgiaovien.id,
                                            chk.value
                                        );
                                        txtSotiet.textContent = tongsotiet;
                                        sotietchuaphancong.textContent = sotiet;
                                        if (tongsotiet == 0) {
                                            chk.classList.remove("selected");
                                        }
                                    }
                                }
                                hienthidanhsachLopday(ttgiaovien.id, chk.value);
                                hienthiTongsotiet(ttgiaovien.id);
                            };
                            tdChon.appendChild(inputChon);

                            // Nut xoa phan cong day tung lop

                            let tdXoa = document.createElement("td");
                            let buttonXoa = document.createElement("button");
                            buttonXoa.setAttribute(
                                "class",
                                "btn btn-sm btn-danger"
                            );
                            buttonXoa.onclick = function (e) {
                                let findGiaovien = danhsachphancong.findIndex(
                                    (o) =>
                                        o.malop == item.id &&
                                        o.mamonhoc == chk.value
                                );
                                // Xoa phan cong giao vien duoc chon
                                xoaPhancong.push(
                                    danhsachphancong[findGiaovien]
                                );
                                // Xoa trong bang danh sach phan cong
                                sotietchuaphancong.textContent =
                                    danhsachphancong[findGiaovien].sotiet;
                                danhsachphancong.splice(findGiaovien, 1);
                                let indexSotiet = sotietmon.findIndex(
                                    (x) =>
                                        x.mamonhoc == chk.value &&
                                        x.malop == item.id
                                );
                                if (indexSotiet > -1) {
                                    inputsotiettd.value =
                                        sotietmon[indexSotiet].sotiet;
                                }
                                inputsotiettd.disabled = false;
                                giaovien.textContent = "";
                                buttonXoa.disabled = true;
                                inputChon.disabled = false;
                            };

                            buttonXoa.appendChild(
                                document.createTextNode("Xóa")
                            );
                            tdXoa.appendChild(buttonXoa);
                            tr.appendChild(stt);
                            tr.appendChild(lop);
                            tr.appendChild(tdChon);
                            tr.appendChild(sotiettd);
                            tr.appendChild(sotietchuaphancong);
                            tr.appendChild(giaovien);
                            tr.appendChild(tdXoa);
                            bangdanhsachphancongchomonhoc.appendChild(tr);
                            stt++;
                        });
                    }
                };

                chon.appendChild(chk);

                let sotiet = creatTd("");
                sotiet.setAttribute("data-mon", item.id);
                sotiet.setAttribute("class", "txtSotietmon");
                sotiet.setAttribute("data-giaovien", ttgiaovien.id);
                sotiet.setAttribute("data-lop", item.malop);
                // Tinh tong so tiet

                let temp = danhsachphancong.filter(
                    (x) =>
                        x.magiaovien == sotiet.dataset.giaovien &&
                        x.mamonhoc == sotiet.dataset.mon
                );
                let sum = 0;
                temp.forEach((element) => {
                    sum += element.sotiet;
                });

                sotiet.textContent = sum > 0 ? sum : "";
                // tr.appendChild(stt);
                tr.appendChild(mon);
                tr.appendChild(chon);
                tr.appendChild(lopday);
                tr.appendChild(sotiet);
                bangdanhsachmonpc.appendChild(tr);
                // Hien thi danh sach cac lop duoc phan cong cho giao vien neu co
                hienthidanhsachLopday(ttgiaovien.id, item.id, true);
                index++;
            });

            $("#modelPhancong").modal("show");
        };
        let tdPCCM = document.createElement("td");

        tdPCCM.appendChild(buttonPCCM);

        let buttonXoa = document.createElement("button");
        buttonXoa.setAttribute("class", "btn btn-sm btn-danger");
        buttonXoa.setAttribute(`data-id`, item.magiaovien);
        let lblXoa = document.createTextNode("Xóa PCCM");
        buttonXoa.appendChild(lblXoa);
        buttonXoa.addEventListener("click", (e) => {
            // Xoa toan bo danh sach phan cong cua giao vien hien tai
            let idGiaovien = buttonXoa.dataset.id;
            Swal.fire({
                title:
                    "Bạn có muốn xóa toàn bộ phân công chuyên môn của giáo viên không?",
                text: "Xóa tất cả phân công chuyên môn",
                icon: "question",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Có",
                cancelButtonText: "Không",
                confirmButtonColor: "red",
            }).then((isConfirm) => {
                if (isConfirm.value == true) {
                    xoaToanboPhancongcuaGiaovien(idGiaovien).then((res) => {
                        if (res.code == http.CODE_SUCCESS) {
                            window.location.reload();
                        } else {
                            Swal.fire(
                                "Đã xảy ra lỗi vui lòng thử lại sau",
                                "Không thể xóa phân công",
                                "error"
                            );
                        }
                    });
                }
            });
        });
        let tdXoa = document.createElement("td");
        tdXoa.appendChild(buttonXoa);

        tr.appendChild(stt);
        tr.appendChild(hovaten);
        tr.appendChild(bidanh);
        tr.appendChild(sotiet);
        tr.appendChild(chuyenmon);
        tr.appendChild(tdPCCM);
        tr.appendChild(tdXoa);
        bangdanhsachphancong.appendChild(tr);
        index++;
    });
}

function creatTd(texts = null, childControl = null, className = "") {
    let td = document.createElement("td");
    td.setAttribute("class", className);
    if (childControl == null && texts != null) {
        let text = document.createTextNode(texts);
        td.appendChild(text);
    }
    return td;
}
function tinhTongsotiet(giaovien, monhoc) {
    let tongsotiet = 0;
    bangphancongTam.forEach((item) => {
        if (item.magiaovien == giaovien && item.mamonhoc == monhoc) {
            tongsotiet += item.sotiet;
        }
    });

    return tongsotiet;
}

// Hiện thị tổng số tiết và chi tiết phân công dạy học của giáo viên
function hienthiTongsotiet(giaovien) {
    // Tong hop tong so cac mon duoc phan cong cho giao vien nay

    let danhsachPhancong = bangphancongTam.filter(
        (x) => x.magiaovien == giaovien
    );

    let arrMon = [];
    danhsachPhancong.map((item) => {
        let find = arrMon.findIndex((x) => x.mamonhoc == item.mamonhoc);
        if (find == -1) {
            arrMon.push(item);
        }
    });

    // Hien thi danh sach mon hoc da phan cong theo tung mon hoc
    let result = "";
    let tong = 0;

    arrMon.forEach((mon) => {
        let tongsotiet = 0;
        let lop = "";
        // Lay danh sach cac tiet day cua mon hoc
        let ds = bangphancongTam.filter(
            (x) => x.mamonhoc == mon.mamonhoc && x.magiaovien == giaovien
        );
        let m = danhsachmonhoc.findIndex((mons) => mons.id == mon.mamonhoc);
        m = danhsachmonhoc[m];
        ds.forEach((item) => {
            let findLop = danhsachLop.findIndex((l) => l.id == item.malop);
            lop += danhsachLop[findLop].tenlop + ",";
            tongsotiet += item.sotiet;
        });
        result += `<span>${m.tenmonhoc}: ${tongsotiet}(${bodauphaycuoichuoi(
            lop
        )}) </span>`;
    });
    danhsachPhancong.map((item) => {
        tong += item.sotiet;
    });
    lblTongsotiet.innerHTML = `Tổng số tiết: ${tong} trong đó: ` + result;
}
function bodauphaycuoichuoi(str) {
    return str.replace(/,(\s+)?$/, "");
}

/**
 *
 * @param {*} giaovien
 * @param {*} monhoc
 * @param {*} chuachon Lay du lieu tu bang phan cong tam hay tu bang phan cong duoc lay tu tren server ve
 */
function hienthidanhsachLopday(giaovien, monhoc, chuachon = false) {
    let danhsachPhancong;
    if (chuachon == false) {
        danhsachPhancong = bangphancongTam.filter(
            (x) => x.magiaovien == giaovien && x.mamonhoc == monhoc
        );
    } else {
        danhsachPhancong = danhsachphancong.filter(
            (x) => x.magiaovien == giaovien && x.mamonhoc == monhoc
        );
    }

    // Lay danh sach cac lop co lien quan
    let lop = "";
    danhsachPhancong.map((item) => {
        let index = danhsachLop.findIndex((i) => i.id == item.malop);
        lop += danhsachLop[index].tenlop + ",";
    });
    let td = document.querySelector(
        '.tdLopdayMon[data-lopdaymon="' + monhoc + '"]'
    );
    td.textContent = bodauphaycuoichuoi(lop);
}
/**
 * hàm hiển thị danh sách các chuyên môn được phân cho giáo viên
 * @param {*} danhsach danh sach cac mon được phân cho giáo viên
 * @param {*} td ô chứa thông tin về cấc chuyên môn
 */
function hienThiChuyenMon(danhsach, td) {
    let cm = "";
    danhsach = danhsach.filter(function (item, pos, self) {
        return self.indexOf(item) == pos;
    });
    danhsach.forEach((item) => {
        cm += item.tenmonhoc + ",";
    });
    td.textContent = bodauphaycuoichuoi(cm);
}
/**
 * Ham hien thi tong so tiet cua giao vien
 * @param {*} danhsachphanmon danh sach phan mon cua giao vien
 * @param {*} td
 */
function hienthitongsotietGiaovien(danhsachphanmon, td) {
    let tong = 0;
    danhsachphanmon.forEach((item) => {
        tong += item.sotiet;
    });
    td.textContent = tong;
}

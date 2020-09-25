import { baseURl } from "../api/api.js";
import xuattkbapi from "../api/xuattkbapi.js";

var listTeacherBody,
    xuattkbtongquat,
    xuattkblop,
    xuattkbgiaovien,
    xuattkbphancongcm,
    xuattkbphong,
    xuattkb,
    dateprocess,
    chkSelectTeacher,
    selectAllEmail,
    progress,
    listTeacher,
    sendTKBwithEmail,
    emailTitle,
    emailContent,
    searchTeacher,
    progressbarTitle,
    savetkb,
    exportTkb;

var tkbCode = "";

var arrFile = [];
window.onload = function () {
    initControl();
    initData();
    initEvent();
};

function initControl() {
    listTeacherBody = document.getElementById("listTeacherBody");
    listTeacher = document.getElementById("listTeacher");
    xuattkbtongquat = document.getElementById("xuattkbtongquat");
    xuattkblop = document.getElementById("xuattkblop");
    xuattkbgiaovien = document.getElementById("xuattkbgiaovien");
    xuattkbphancongcm = document.getElementById("xuattkbphancongcm");
    xuattkbphong = document.getElementById("xuattkbphong");
    xuattkb = document.getElementById("xuattkb");
    progressbarTitle = document.getElementById("progressbarTitle");
    const now = new Date();
    $("#dateprocess").dxDateBox({
        type: "date",
        max: now,
        min: new Date(1900, 0, 1),
        value: now,
    });
    selectAllEmail = document.getElementById("selectAllEmail");
    progress = document.getElementsByClassName("progress");
    sendTKBwithEmail = document.getElementById("sendTKBwithEmail");
    emailTitle = document.getElementById("emailTitle");
    emailContent = document.getElementById("emailContent");
    searchTeacher = document.getElementById("searchTeacher");
}

// async function initListTeacher() {
//     let listTeacher = await xuattkbapi.getListTeacher();
//     let html = "";
//     let stt = 1;
//     listTeacher.forEach((element) => {
//         html += `<tr>
//         <td class="">${stt}</td>
//         <td><input type="checkbox" data-email="${
//             element.email
//         }" class="emailTeacher" /></td>
//         <td class="tdTeacherName">${element.hovaten}</td>
//         <td>${element.email != null ? element.email : ""}</td>
//         </tr>`;
//         stt++;
//     });
//     listTeacherBody.innerHTML = html;
// }

function initData() {
    //  initListTeacher();
}

function initEvent() {
    xuattkb.onclick = function (e) {
        downLoadTKBEvent();
    };
    // searchTeacher.oninput = function (e) {
    //     Search("tdTeacherName", searchTeacher);
    // };

    // // // sendTKBwithEmail.onclick = async function (e) {
    // // //     let emails = [];

    // // //     if (chkSelectTeacher.checked) {
    // // //         progress[0].classList.remove("hidden");
    // // //         progressbarTitle.textContent =
    // // //             "Đang gửi thời khóa biểu cho giáo viên xin vui lòng chờ cho đến khi hoàn tất";
    // // //         let chkEmail = document.querySelectorAll(".emailTeacher:checked");
    // // //         for (const email of chkEmail) {
    // // //             emails.push(email.dataset.email);
    // // //         }
    // // //         if (tkbCode == "") {
    // // //             await exportExcel();
    // // //             if (tkbCode != "") {
    // // //                 sendMail(emails);
    // // //             }
    // // //         } else {
    // // //             sendMail(emails);
    // // //         }
    // // //     } else {
    // // //         let chkEmail = document.querySelectorAll(".emailTeacher");
    // // //         for (const email of chkEmail) {
    // // //             emails.push(email.dataset.email);
    // // //         }
    // // //         if (tkbCode == "") {
    // // //             await exportExcel();
    // // //             if (tkbCode != "") {
    // // //                 sendMail(emails);
    // // //             }
    // // //         } else {
    // // //             sendMail(emails);
    // // //         }
    // // //     }
    // // //     progress[0].classList.add("hidden");
    // // // };
    // // chkSelectTeacher.onclick = function (e) {
    // //     if (!e.target.checked) {
    // //         listTeacher.classList.add("hidden");
    // //     } else {
    // //         listTeacher.classList.remove("hidden");
    // //     }
    // // };

    // selectAllEmail.onclick = function (e) {
    //     let emailList = document.querySelectorAll(".emailTeacher");
    //     for (const chk of emailList) {
    //         chk.checked = e.target.checked;
    //     }
    // };

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
        emailTitle: emailTitle.value,
        emailContent: emailContent.value,
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
    arrFile.forEach((file) => {
        window.open(`${baseURl}xuattkb/export/${file}.xlsx`);
    });
    arrFile.length = 0;
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

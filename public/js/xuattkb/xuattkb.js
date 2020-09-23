import { baseURl } from "../api/api.js";
import xuattkbapi from "../api/xuattkbapi.js";

var listTeacherBody,
    chkTKBSchollMVDuo,
    chkTKBSchollMV,
    chkTKBSchollMVDuoLine,
    chkTKBSchollM,
    chkTKBLopMGV,
    chkTKBLopM,
    chkTKBGV1ML,
    chkTKBGV1M,
    chkTKBGV1L,
    chkTKBGV2ML,
    chkTKBGV2M,
    chkTKBGV2L,
    chkTKBGV3ML,
    chkTKBGV3M,
    chkTKBGV3L,
    chkTKBPBMML,
    chkTKBPBMMGV,
    chkTKBPBMGVL,
    chkTKBTNML,
    btnDownloadTKB,
    dateprocess,
    tkbNo,
    chkSelectTeacher,
    selectAllEmail,
    progress,
    listTeacher,
    sendTKBwithEmail,
    emailTitle,
    emailContent,
    searchTeacher,
    progressbarTitle;

var tkbCode = "";

window.onload = function () {
    initControl();
    initData();
    initEvent();
};

function initControl() {
    listTeacherBody = document.getElementById("listTeacherBody");
    listTeacher = document.getElementById("listTeacher");
    chkTKBSchollMVDuo = document.getElementById("chkTKBSchollMVDuo");
    chkTKBSchollMV = document.getElementById("chkTKBSchollMV");
    chkTKBSchollMVDuoLine = document.getElementById("chkTKBSchollMVDuoLine");
    chkTKBSchollM = document.getElementById("chkTKBSchollM");
    chkTKBLopMGV = document.getElementById("chkTKBLopMGV");
    chkTKBLopM = document.getElementById("chkTKBLopM");
    chkTKBGV1ML = document.getElementById("chkTKBGV1ML");
    chkTKBGV1M = document.getElementById("chkTKBGV1M");
    chkTKBGV1L = document.getElementById("chkTKBGV1L");
    chkTKBGV2ML = document.getElementById("chkTKBGV2ML");
    chkTKBGV2M = document.getElementById("chkTKBGV2M");
    chkTKBGV2L = document.getElementById("chkTKBGV2L");
    chkTKBGV3ML = document.getElementById("chkTKBGV3ML");
    chkTKBGV3M = document.getElementById("chkTKBGV3M");
    chkTKBPBMML = document.getElementById("chkTKBPBMML");
    chkTKBGV3L = document.getElementById("chkTKBGV3L");
    chkTKBPBMMGV = document.getElementById("chkTKBPBMMGV");
    chkTKBPBMGVL = document.getElementById("chkTKBPBMGVL");
    chkTKBTNML = document.getElementById("chkTKBTNML");
    btnDownloadTKB = document.getElementById("btnDownloadTKB");
    progressbarTitle = document.getElementById("progressbarTitle");
    const now = new Date();
    $("#dateprocess").dxDateBox({
        type: "date",
        max: now,
        min: new Date(1900, 0, 1),
        value: now,
    });
    tkbNo = document.getElementById("tkbNo");
    chkSelectTeacher = document.getElementById("chkSelectTeacher");
    selectAllEmail = document.getElementById("selectAllEmail");
    progress = document.getElementsByClassName("progress");
    sendTKBwithEmail = document.getElementById("sendTKBwithEmail");
    emailTitle = document.getElementById("emailTitle");
    emailContent = document.getElementById("emailContent");
    searchTeacher = document.getElementById("searchTeacher");
}

async function initListTeacher() {
    let listTeacher = await xuattkbapi.getListTeacher();
    let html = "";
    let stt = 1;
    listTeacher.forEach((element) => {
        html += `<tr>
        <td class="">${stt}</td>
        <td><input type="checkbox" data-email="${
            element.email
        }" class="emailTeacher" /></td>
        <td class="tdTeacherName">${element.hovaten}</td>
        <td>${element.email != null ? element.email : ""}</td>
        </tr>`;
        stt++;
    });
    listTeacherBody.innerHTML = html;
}
function initData() {
    initListTeacher();
}
function initEvent() {
    searchTeacher.oninput = function (e) {
        Search("tdTeacherName", searchTeacher);
    };
    sendTKBwithEmail.onclick = async function (e) {
        let emails = [];

        if (chkSelectTeacher.checked) {
            progress[0].classList.remove("hidden");
            progressbarTitle.textContent =
                "Đang gửi thời khóa biểu cho giáo viên xin vui lòng chờ cho đến khi hoàn tất";
            let chkEmail = document.querySelectorAll(".emailTeacher:checked");
            for (const email of chkEmail) {
                emails.push(email.dataset.email);
            }
            if (tkbCode == "") {
                await exportExcel();
                if (tkbCode != "") {
                    sendMail(emails);
                }
            } else {
                sendMail(emails);
            }
        } else {
            let chkEmail = document.querySelectorAll(".emailTeacher");
            for (const email of chkEmail) {
                emails.push(email.dataset.email);
            }
            if (tkbCode == "") {
                await exportExcel();
                if (tkbCode != "") {
                    sendMail(emails);
                }
            } else {
                sendMail(emails);
            }
        }
        progress[0].classList.add("hidden");
    };
    chkSelectTeacher.onclick = function (e) {
        if (!e.target.checked) {
            listTeacher.classList.add("hidden");
        } else {
            listTeacher.classList.remove("hidden");
        }
    };

    selectAllEmail.onclick = function (e) {
        let emailList = document.querySelectorAll(".emailTeacher");
        for (const chk of emailList) {
            chk.checked = e.target.checked;
        }
    };

    btnDownloadTKB.onclick = function (e) {
        downLoadTKBEvent();
    };
}

async function downLoadTKBEvent() {
    await exportExcel();
    await downloadTkb();
}

async function sendMail(listMail) {
    let result = await xuattkbapi.sendEmail({
        tkbNo: tkbCode,
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
    let tkbSchool,
        tkbClass,
        tkbGV1,
        tkbGV2,
        tkbGV3,
        tkbRoomDepartment,
        tkbGroup;
    if (tkbNo.value == "") {
        Swal.fire(
            "Xin vui lòng nhập số hiệu của thời khóa biểu",
            "Nhập số hiệu của thời khóa biểu",
            "warning"
        );
    } else {
        progress[0].classList.remove("hidden");
        if (chkTKBSchollMVDuo.checked == true) {
            tkbSchool = 1;
        }
        if (chkTKBSchollMV.checked) {
            tkbSchool = 2;
        }
        if (chkTKBSchollMVDuoLine.checked) {
            tkbSchool = 3;
        }
        if (chkTKBSchollM.checked) {
            tkbSchool = 4;
        }

        if (chkTKBLopMGV.checked) {
            tkbClass = 1;
        }
        if (chkTKBLopM.checked) {
            tkbClass = 2;
        }

        if (chkTKBGV1ML.checked) {
            tkbGV1 = 1;
        }
        if (chkTKBGV1M.checked) {
            tkbGV1 = 2;
        }

        if (chkTKBGV1L.checked) {
            tkbGV1 = 3;
        }

        if (chkTKBGV2ML.checked) {
            tkbGV2 = 1;
        }
        if (chkTKBGV2M.checked) {
            tkbGV2 = 2;
        }

        if (chkTKBGV2L.checked) {
            tkbGV2 = 3;
        }

        if (chkTKBGV3ML.checked) {
            tkbGV3 = 1;
        }
        if (chkTKBGV3M.checked) {
            tkbGV3 = 2;
        }

        if (chkTKBGV3L.checked) {
            tkbGV3 = 3;
        }

        if (chkTKBPBMML.checked) {
            tkbRoomDepartment = 1;
        }

        if (chkTKBPBMMGV.checked) {
            tkbRoomDepartment = 2;
        }

        if (chkTKBPBMGVL.checked) {
            tkbRoomDepartment = 3;
        }

        if (chkTKBTNML.checked) {
            tkbGroup = 1;
        }
        let date = $("#dateprocess").dxDateBox("instance").option("value");
        date = moment(date).format("DD/MM/YYYY");
        let result = await xuattkbapi.export(
            JSON.stringify({
                tkbSchool: tkbSchool,
                tkbClass: tkbClass,
                tkbGV1: tkbGV1,
                tkbGV2: tkbGV2,
                tkbGV3: tkbGV3,
                tkbRoomDepartment: tkbRoomDepartment,
                tkbGroup: tkbGroup,
                tkbNo: tkbNo.value,
                date: date,
            })
        );
        progress[0].classList.add("hidden");
        tkbCode = result;
    }
}

function downloadTkb() {
    window.open(`${baseURl}xuattkb/export/${tkbCode}`);
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

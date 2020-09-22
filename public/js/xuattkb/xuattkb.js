import { baseURl } from "../api/api.js";
import xuattkbapi from "../api/xuattkbapi.js";
import { download } from "../ultils/ultils.js";

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
    tkbNo;

window.onload = function () {
    initControl();
    initData();
    initEvent();
};

function initControl() {
    listTeacherBody = document.getElementById("listTeacherBody");
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
    $("#dateprocess").datepicker();
    tkbNo = document.getElementById("tkbNo");
}

async function initListTeacher() {
    let listTeacher = await xuattkbapi.getListTeacher();
    let html = "";
    let stt = 1;
    listTeacher.forEach((element) => {
        html += `<tr>
        <td>${stt}</td>
        <td><input type="checkbox" /></td>
        <td>${element.hovaten}</td>
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
    let tkbSchool,
        tkbClass,
        tkbGV1,
        tkbGV2,
        tkbGV3,
        tkbRoomDepartment,
        tkbGroup;

    btnDownloadTKB.onclick = async function (e) {
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
                date: $("#dateprocess").val(),
            })
        );

        window.open(`${baseURl}xuattkb/export/${result}`);
    };
}

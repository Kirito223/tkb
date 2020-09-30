import {layDulieu} from "../api/xeptkbApi.js";

// Chuong trinh sap xep thoi khoa bieu
var tainguyen = null;
var Tientrinhxepthoikhoabieu;
var thoigianchay;
var thoikhoaBieutam = [];
var arrrangbuoc = [];
var arrPhonghoc = [];
var arrLophoc = [];
var arrGiaovien = [];
var idgiaovien = null;
var idlop = null;
var dataloptkbtong = [];
// Cac control
var btnXepTKB,
btnDungXepTKB,
lblVongthu,
lblThoigian,
ulRangbuoc,
BangThoikhoabieu,
btnTepTucxepTKB,
girdChondanhsach,
tieudeChon,
chkChontatca,btnxemtkb,dungxeptkb,capnhattkb;

// Nha kho noi chua toan bo du lieu cua thoi khoa bieu
var kho = null;

window.onload = function() {
    createtkbtong();
    // Tai cac du lieu can thiet
    Taidulieu();
    // Anh xa cac control
    initControl();
    // Cai dat cac su kien control
    ControlEvent();
};


function createtkbtong() {
    var data = axios.get('getdanhsachlophoc').then(function(response) {
        var data10 = response.data;
        var data1 = data10.sort(function(a, b) {
            return a.tenlop.localeCompare(b.tenlop);
        });
        dataloptkbtong.push(data1);
        var table = document.getElementById("example");
        var thead = document.createElement("thead");
        table.appendChild(thead);
        thead.insertRow(0);
        thead.rows[0].insertCell(0);
        thead.rows[0].cells[0].appendChild(document.createTextNode("Thứ"));
        thead.rows[0].insertCell(1);
        thead.rows[0].cells[1].appendChild(document.createTextNode("Tiết"));


        var tblBody = document.createElement("tbody");
        tblBody.setAttribute("id", "tkb");
        table.appendChild(tblBody);

        for (var i = 0; i < data1.length; i++) {
            var itemlop = data1[i].tenlop;
            var itemcell = i + 2;
            thead.rows[0].insertCell(itemcell);
            thead.rows[0].cells[itemcell].appendChild(document.createTextNode(itemlop));
        }

        for (var z = 0; z < 60; z++) {
            var row = document.createElement("tr");
            for (var h = 0; h < (data1.length + 2); h++) {
                var cell = document.createElement("td");
                var cellText = document.createTextNode("");
                cell.appendChild(cellText);
                row.appendChild(cell);
                cell.setAttribute("draggable", "true");
                cell.setAttribute("border", "1px solid #ddd");
            }
            tblBody.appendChild(row);
        }



        for (var ii = 0; ii < 56; ii++) {
            if (ii == 0) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 2 Sáng ");
                for (var j = 1; j < 6; j++) {
                    if (j == 1) {
                        $('#tkb tr:eq(0) td:eq(1)').html(j);
                    } else {
                        $('#tkb tr:eq(' + (j - 1) + ') td:eq(0)').html(j);
                    }

                }
            } else if (ii == 5) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 2 chiều ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(5) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (4 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 10) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 3 sáng ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(10) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (9 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 15) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 3 chiều ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(15) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (14 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 20) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 4 sáng ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(20) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (19 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 25) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 4 chiều ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(25) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (24 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 30) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 5 sáng ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(30) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (29 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 35) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 5 chiều ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(35) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (34 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 40) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 6 sáng ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(40) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (39 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 45) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 6 chiều ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(45) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (44 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 50) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 7 sáng ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(50) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (49 + q) + ') td:eq(0)').html(q);
                    }
                }
            } else if (ii == 55) {
                $('#tkb tr:eq(' + ii + ') td:eq(0)').attr('rowspan', 5).html("Thứ 7 chiều ");
                for (var q = 1; q < 6; q++) {
                    if (q == 1) {
                        $('#tkb tr:eq(55) td:eq(1)').html(q);
                    } else {
                        $('#tkb tr:eq(' + (54 + q) + ') td:eq(0)').attr('draggable', 'true').html(q);
                    }
                }
            }
        }




    });
}



async function Taidulieu() {
    kho = await layDulieu();
    // Swal.fire("Đã tải xong dữ liệu", "Tải xong dữ liệu", "success");
}

function initControl() {
    btnXepTKB = document.getElementById("btnxepthoikhoabieu");
    btnDungXepTKB = document.getElementById("btnDungxepthoikhoabieu");
    lblVongthu = document.getElementById("lblVongthu");
    lblThoigian = document.getElementById("lblThoigian");
    ulRangbuoc = document.getElementById("girddsrangbuoc");
    BangThoikhoabieu = document.getElementById("BangThoikhoabieu");
    btnTepTucxepTKB = document.getElementById("btnTepTucxepTKB");
    girdChondanhsach = document.getElementById("girdChondanhsach");
    tieudeChon = document.getElementById("tieudeChon");
    chkChontatca = document.getElementById("chkChontatca");
    btnxemtkb = document.getElementById("btnxemtkb");
	
	dungxeptkb = document.getElementById("dungxeptkb");
    capnhattkb = document.getElementById("capnhattkb");
}

function ControlEvent() {
    btnXepTKB.onclick = function(e) {
        document.getElementById("btnxepthoikhoabieu").style.display = "none";
        document.getElementById("btnDungxepthoikhoabieu").style.display = "block";
        document.getElementById("btnTepTucxepTKB").style.display = "none";
        batDauxepTKB();
    };
    btnDungXepTKB.onclick = function(e) {
        document.getElementById("btnxepthoikhoabieu").style.display = "block";
        document.getElementById("btnDungxepthoikhoabieu").style.display = "none";
        document.getElementById("btnTepTucxepTKB").style.display = "block";
        console.log("stop");
        dungxepTKB();
    };
	    dungxeptkb.onclick = function(e) {
        document.getElementById("btnxepthoikhoabieu").style.display = "block";
        document.getElementById("btnDungxepthoikhoabieu").style.display = "none";
        document.getElementById("btnTepTucxepTKB").style.display = "block";
        console.log("stop");
        dungxepTKB();
    };
    btnTepTucxepTKB.onclick = function(e) {
        document.getElementById("btnxepthoikhoabieu").style.display = "none";
        document.getElementById("btnDungxepthoikhoabieu").style.display = "block";
        document.getElementById("btnTepTucxepTKB").style.display = "none";
        tieptucXepTKB();
    };

    btnxemtkb.onclick = function() {
        document.getElementById("cardxeptkb").style.display = "block";
        // document.getElementById("card").style.display = "block";
    };
	    capnhattkb.onclick = function() {
        btncapnhattkb();
    };


}

// Sap xep thoi khoa bieu cac lop bang cach tao nhieu theard worker de sap xep cung luc

function taoThoikhoabieu() {
    Tientrinhxepthoikhoabieu = new Worker("public/js/xeptkb/woker.js");
    // Thiet lap ham sap xep thoi khoa bieu

    // Nhận tin nhắn từ worker trả về và gọi hàm cập nhật dữ liệu len ui
    Tientrinhxepthoikhoabieu.onmessage = CapnhatTKB;

    
    // Gửi tin nhắn cho luồng phuj cùng các data cần thiết
    Tientrinhxepthoikhoabieu.postMessage({
        kho: kho,
        thoikhoaBieutam: thoikhoaBieutam,
        
    });
}




function hienThithoigian() {
    let gio = 0;
    let phut = 0;
    let giay = 0;
    thoigianchay = setInterval(function() {
        giay++;
        if (giay == 60) {
            phut++;
            giay = 0;
        }
        if (phut == 60) {
            gio++;
            phut = 0;
        }

        lblThoigian.textContent = `${gio}:${phut < 10 ? "0" + phut : phut}:${
            giay < 10 ? "0" + giay : giay
        }`;
    }, 1000);
}

function batDauxepTKB() {
    if (kho != null) {
        if (Tientrinhxepthoikhoabieu == null) {
            setRangbuoc();
            hienThithoigian();
            taoThoikhoabieu();
        }
    }
}



var datatkb;
function CapnhatTKB(event) {
    let data = event.data;

    let dataloc = event.data.tkb;
    var locdata = dataloc.filter(function(number) {
        if (number.hovatengv != "") {
            return number;
        }
    });
    var locdatasort = locdata.sort(function(a, b) {
        return a.tenlop.localeCompare(b.tenlop);
    });
    datatkb = locdatasort;

    // Cap nhat thoi khoa bieu len giao dien
    // tabletkb(data.tkb);
    if (idgiaovien != null) {
        let datagiaovien = thoikhoabieugiaovien(idgiaovien, locdata);
        //show tkb theo giáo viên ....
        danhsachlophoc();
    }

    if (idlop != null) {
        let datalop = thoikhoabieulop(idlop, locdata);
        //show tkb theo lớp
    }
    var idloptkbtong = dataloptkbtong[0];


    var datas = locdatasort;


    






    var sttloptkbtong = idloptkbtong.map(function(value, label) {
        let data = value;
        let stt = label + 1;
        var sttloptkbtong = Object.assign(data, {
            stt: stt.toString()
        });
        return sttloptkbtong;
    });


    //t2 tiet 1
    let lucky2t1 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    //t3 tiet 1
    let lucky3t1 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    //t4 tiet 1
    let lucky4t1 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    //t5 tiet 1
    let lucky5t1 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    //t6 tiet 1
    let lucky6t1 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    //t7 tiet 1
    let lucky7t1 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });


    //t2 tiet 2
    let lucky2t2 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    //t3 tiet 2
    let lucky3t2 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    //t4 tiet 2
    let lucky4t2 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    //t5 tiet 2
    let lucky5t2 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    //t6 tiet 2
    let lucky6t2 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    //t7 tiet 2
    let lucky7t2 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });


    //t2 tiet 3
    let lucky2t3 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    //t3 tiet 3
    let lucky3t3 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    //t4 tiet 3
    let lucky4t3 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    //t5 tiet 3
    let lucky5t3 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    //t6 tiet 3
    let lucky6t3 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    //t7 tiet 3
    let lucky7t3 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });


    //t2 tiet 4
    let lucky2t4 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    //t3 tiet 4
    let lucky3t4 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    //t4 tiet 4
    let lucky4t4 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    //t5 tiet 4
    let lucky5t4 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    //t6 tiet 4
    let lucky6t4 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    //t7 tiet 4
    let lucky7t4 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });


    //t2 tiet 5
    let lucky2t5 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    //t3 tiet 5
    let lucky3t5 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    //t4 tiet 5
    let lucky4t5 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    //t5 tiet 5
    let lucky5t5 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    //t6 tiet 5
    let lucky6t5 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    //t7 tiet 5
    let lucky7t5 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });


    //t2 tiet 6
    let lucky2t6 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    //t3 tiet 6
    let lucky3t6 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    //t4 tiet 6
    let lucky4t6 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    //t5 tiet 6
    let lucky5t6 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    //t6 tiet 6
    let lucky6t6 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    //t7 tiet 6
    let lucky7t6 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });


    //t2 tiet 7
    let lucky2t7 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    //t3 tiet 7
    let lucky3t7 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    //t4 tiet 7
    let lucky4t7 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    //t5 tiet 7
    let lucky5t7 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    //t6 tiet 7
    let lucky6t7 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    //t7 tiet 7
    let lucky7t7 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });


    //t2 tiet 8
    let lucky2t8 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    //t3 tiet 8
    let lucky3t8 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    //t4 tiet 8
    let lucky4t8 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    //t5 tiet 8
    let lucky5t8 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    //t6 tiet 8
    let lucky6t8 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    //t7 tiet 8
    let lucky7t8 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });


    //t2 tiet 9
    let lucky2t9 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    //t3 tiet 9
    let lucky3t9 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    //t4 tiet 9
    let lucky4t9 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    //t5 tiet 9
    let lucky5t9 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    //t6 tiet 9
    let lucky6t9 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    //t7 tiet 9
    let lucky7t9 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });


    //t2 tiet 10
    let lucky2t10 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    //t3 tiet 10
    let lucky3t10 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    //t4 tiet 10
    let lucky4t10 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    //t5 tiet 10
    let lucky5t10 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    //t6 tiet 10
    let lucky6t10 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    //t7 tiet 10
    let lucky7t10 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });



    for (var o = 0; o < sttloptkbtong.length; o++) {
        var cell = document.getElementsByTagName("td")[o + 2].cellIndex;
        var stts = sttloptkbtong[o].stt;
        var stt = parseInt(stts, 10);
        var malop = sttloptkbtong[o].id;
        $('#tkb tr').attr('style','border: 1px solid #ddd;');
        for (var j = 0; j < 60; j++) {
            var row = document.getElementsByTagName("tr")[j];
            //tiet 1
            lucky2t1.filter(function(number) {
                var gv2t1 = number.hovatengv;
                var mon2t1 = number.tenmon;
                var lop2t1 = number.malop;
                var thu2t1 = '<a style="white-space: nowrap;">' + mon2t1 + ' - ' + gv2t1 + '</a>';
                if (j == 0 && malop == lop2t1 && cell == (stt + 1)) {
                    $('#tkb tr:eq(0) td:eq(' + (cell) + ')').html(thu2t1).attr('style','border: 1px solid #ddd;');
                } 
            })
            lucky3t1.filter(function(number) {
                var gv3t1 = number.hovatengv;
                var mon3t1 = number.tenmon;
                var lop3t1 = number.malop;
                var thu3t1 = '<a style="white-space: nowrap;">' + mon3t1 + ' - ' + gv3t1 + '</a>';
                if (j == 10 && malop == lop3t1 && cell == (stt + 1)) {
                    $('#tkb tr:eq(10) td:eq(' + (cell) + ')').html(thu3t1).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t1.filter(function(number) {
                var gv4t1 = number.hovatengv;
                var mon4t1 = number.tenmon;
                var lop4t1 = number.malop;
                var thu4t1 = '<a style="white-space: nowrap;">' + mon4t1 + ' - ' + gv4t1 + '</a>';
                if (j == 20 && malop == lop4t1 && cell == (stt + 1)) {
                    $('#tkb tr:eq(20) td:eq(' + (cell) + ')').html(thu4t1).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t1.filter(function(number) {
                var gv5t1 = number.hovatengv;
                var mon5t1 = number.tenmon;
                var lop5t1 = number.malop;
                var thu5t1 = '<a style="white-space: nowrap;">' + mon5t1 + ' - ' + gv5t1 + '</a>';
                if (j == 30 && malop == lop5t1 && cell == (stt + 1)) {
                    $('#tkb tr:eq(30) td:eq(' + (cell) + ')').html(thu5t1).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t1.filter(function(number) {
                var gv6t1 = number.hovatengv;
                var mon6t1 = number.tenmon;
                var lop6t1 = number.malop;
                var thu6t1 = '<a style="white-space: nowrap;">' + mon6t1 + ' - ' + gv6t1 + '</a>';
                if (j == 40 && malop == lop6t1 && cell == (stt + 1)) {
                    $('#tkb tr:eq(40) td:eq(' + (cell) + ')').html(thu6t1).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t1.filter(function(number) {
                var gv7t1 = number.hovatengv;
                var mon7t1 = number.tenmon;
                var lop7t1 = number.malop;
                var thu7t1 = '<a style="white-space: nowrap;">' + mon7t1 + ' - ' + gv7t1 + '</a>';
                if (j == 50 && malop == lop7t1 && cell == (stt + 1)) {
                    $('#tkb tr:eq(50) td:eq(' + (cell) + ')').html(thu7t1).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 2
            lucky2t2.filter(function(number) {
                var gv2t2 = number.hovatengv;
                var mon2t2 = number.tenmon;
                var lop2t2 = number.malop;
                var thu2t2 = '<a style="white-space: nowrap;">' + mon2t2 + ' - ' + gv2t2 + '</a>';
                if (j == 1 && malop == lop2t2 && cell == (stt + 1)) {
                    $('#tkb tr:eq(1) td:eq(' + (cell - 1) + ')').html(thu2t2).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t2.filter(function(number) {
                var gv3t2 = number.hovatengv;
                var mon3t2 = number.tenmon;
                var lop3t2 = number.malop;
                var thu3t2 = '<a style="white-space: nowrap;">' + mon3t2 + ' - ' + gv3t2 + '</a>';
                if (j == 11 && malop == lop3t2 && cell == (stt + 1)) {
                    $('#tkb tr:eq(11) td:eq(' + (cell - 1) + ')').html(thu3t2).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t2.filter(function(number) {
                var gv4t2 = number.hovatengv;
                var mon4t2 = number.tenmon;
                var lop4t2 = number.malop;
                var thu4t2 = '<a style="white-space: nowrap;">' + mon4t2 + ' - ' + gv4t2 + '</a>';
                if (j == 21 && malop == lop4t2 && cell == (stt + 1)) {
                    $('#tkb tr:eq(21) td:eq(' + (cell - 1) + ')').html(thu4t2).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t2.filter(function(number) {
                var gv5t2 = number.hovatengv;
                var mon5t2 = number.tenmon;
                var lop5t2 = number.malop;
                var thu5t2 = '<a style="white-space: nowrap;">' + mon5t2 + ' - ' + gv5t2 + '</a>';
                if (j == 31 && malop == lop5t2 && cell == (stt + 1)) {
                    $('#tkb tr:eq(31) td:eq(' + (cell - 1) + ')').html(thu5t2).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t2.filter(function(number) {
                var gv6t2 = number.hovatengv;
                var mon6t2 = number.tenmon;
                var lop6t2 = number.malop;
                var thu6t2 = '<a style="white-space: nowrap;">' + mon6t2 + ' - ' + gv6t2 + '</a>';
                if (j == 41 && malop == lop6t2 && cell == (stt + 1)) {
                    $('#tkb tr:eq(41) td:eq(' + (cell - 1) + ')').html(thu6t2).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t2.filter(function(number) {
                var gv7t2 = number.hovatengv;
                var mon7t2 = number.tenmon;
                var lop7t2 = number.malop;
                var thu7t2 = '<a style="white-space: nowrap;">' + mon7t2 + ' - ' + gv7t2 + '</a>';
                if (j == 51 && malop == lop7t2 && cell == (stt + 1)) {
                    $('#tkb tr:eq(51) td:eq(' + (cell - 1) + ')').html(thu7t2).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 3
            lucky2t3.filter(function(number) {
                var gv2t3 = number.hovatengv;
                var mon2t3 = number.tenmon;
                var lop2t3 = number.malop;
                var thu2t3 = '<a style="white-space: nowrap;">' + mon2t3 + ' - ' + gv2t3 + '</a>';
                if (j == 2 && malop == lop2t3 && cell == (stt + 1)) {
                    $('#tkb tr:eq(2) td:eq(' + (cell - 1) + ')').html(thu2t3).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t3.filter(function(number) {
                var gv3t3 = number.hovatengv;
                var mon3t3 = number.tenmon;
                var lop3t3 = number.malop;
                var thu3t3 = '<a style="white-space: nowrap;">' + mon3t3 + ' - ' + gv3t3 + '</a>';
                if (j == 12 && malop == lop3t3 && cell == (stt + 1)) {
                    $('#tkb tr:eq(12) td:eq(' + (cell - 1) + ')').html(thu3t3).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t3.filter(function(number) {
                var gv4t3 = number.hovatengv;
                var mon4t3 = number.tenmon;
                var lop4t3 = number.malop;
                var thu4t3 = '<a style="white-space: nowrap;">' + mon4t3 + ' - ' + gv4t3 + '</a>';
                if (j == 22 && malop == lop4t3 && cell == (stt + 1)) {
                    $('#tkb tr:eq(22) td:eq(' + (cell - 1) + ')').html(thu4t3).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t3.filter(function(number) {
                var gv5t3 = number.hovatengv;
                var mon5t3 = number.tenmon;
                var lop5t3 = number.malop;
                var thu5t3 = '<a style="white-space: nowrap;">' + mon5t3 + ' - ' + gv5t3 + '</a>';
                if (j == 32 && malop == lop5t3 && cell == (stt + 1)) {
                    $('#tkb tr:eq(32) td:eq(' + (cell - 1) + ')').html(thu5t3).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t3.filter(function(number) {
                var gv6t3 = number.hovatengv;
                var mon6t3 = number.tenmon;
                var lop6t3 = number.malop;
                var thu6t3 = '<a style="white-space: nowrap;">' + mon6t3 + ' - ' + gv6t3 + '</a>';
                if (j == 42 && malop == lop6t3 && cell == (stt + 1)) {
                    $('#tkb tr:eq(42) td:eq(' + (cell - 1) + ')').html(thu6t3).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t3.filter(function(number) {
                var gv7t3 = number.hovatengv;
                var mon7t3 = number.tenmon;
                var lop7t3 = number.malop;
                var thu7t3 = '<a style="white-space: nowrap;">' + mon7t3 + ' - ' + gv7t3 + '</a>';
                if (j == 52 && malop == lop7t3 && cell == (stt + 1)) {
                    $('#tkb tr:eq(52) td:eq(' + (cell - 1) + ')').html(thu7t3).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 4
            lucky2t4.filter(function(number) {
                var gv2t4 = number.hovatengv;
                var mon2t4 = number.tenmon;
                var lop2t4 = number.malop;
                var thu2t4 = '<a style="white-space: nowrap;">' + mon2t4 + ' - ' + gv2t4 + '</a>';
                if (j == 3 && malop == lop2t4 && cell == (stt + 1)) {
                    $('#tkb tr:eq(3) td:eq(' + (cell - 1) + ')').html(thu2t4).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t4.filter(function(number) {
                var gv3t4 = number.hovatengv;
                var mon3t4 = number.tenmon;
                var lop3t4 = number.malop;
                var thu3t4 = '<a style="white-space: nowrap;">' + mon3t4 + ' - ' + gv3t4 + '</a>';
                if (j == 13 && malop == lop3t4 && cell == (stt + 1)) {
                    $('#tkb tr:eq(13) td:eq(' + (cell - 1) + ')').html(thu3t4).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t4.filter(function(number) {
                var gv4t4 = number.hovatengv;
                var mon4t4 = number.tenmon;
                var lop4t4 = number.malop;
                var thu4t4 = '<a style="white-space: nowrap;">' + mon4t4 + ' - ' + gv4t4 + '</a>';
                if (j == 23 && malop == lop4t4 && cell == (stt + 1)) {
                    $('#tkb tr:eq(23) td:eq(' + (cell - 1) + ')').html(thu4t4).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t4.filter(function(number) {
                var gv5t4 = number.hovatengv;
                var mon5t4 = number.tenmon;
                var lop5t4 = number.malop;
                var thu5t4 = '<a style="white-space: nowrap;">' + mon5t4 + ' - ' + gv5t4 + '</a>';
                if (j == 33 && malop == lop5t4 && cell == (stt + 1)) {
                    $('#tkb tr:eq(33) td:eq(' + (cell - 1) + ')').html(thu5t4).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t4.filter(function(number) {
                var gv6t4 = number.hovatengv;
                var mon6t4 = number.tenmon;
                var lop6t4 = number.malop;
                var thu6t4 = '<a style="white-space: nowrap;">' + mon6t4 + ' - ' + gv6t4 + '</a>';
                if (j == 43 && malop == lop6t4 && cell == (stt + 1)) {
                    $('#tkb tr:eq(43) td:eq(' + (cell - 1) + ')').html(thu6t4).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t4.filter(function(number) {
                var gv7t4 = number.hovatengv;
                var mon7t4 = number.tenmon;
                var lop7t4 = number.malop;
                var thu7t4 = '<a style="white-space: nowrap;">' + mon7t4 + ' - ' + gv7t4 + '</a>';
                if (j == 53 && malop == lop7t4 && cell == (stt + 1)) {
                    $('#tkb tr:eq(53) td:eq(' + (cell - 1) + ')').html(thu7t4).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 5
            lucky2t5.filter(function(number) {
                var gv2t5 = number.hovatengv;
                var mon2t5 = number.tenmon;
                var lop2t5 = number.malop;
                var thu2t5 = '<a style="white-space: nowrap;">' + mon2t5 + ' - ' + gv2t5 + '</a>';
                if (j == 4 && malop == lop2t5 && cell == (stt + 1)) {
                    $('#tkb tr:eq(4) td:eq(' + (cell - 1) + ')').html(thu2t5).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t5.filter(function(number) {
                var gv3t5 = number.hovatengv;
                var mon3t5 = number.tenmon;
                var lop3t5 = number.malop;
                var thu3t5 = '<a style="white-space: nowrap;">' + mon3t5 + ' - ' + gv3t5 + '</a>';
                if (j == 14 && malop == lop3t5 && cell == (stt + 1)) {
                    $('#tkb tr:eq(14) td:eq(' + (cell - 1) + ')').html(thu3t5).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t5.filter(function(number) {
                var gv4t5 = number.hovatengv;
                var mon4t5 = number.tenmon;
                var lop4t5 = number.malop;
                var thu4t5 = '<a style="white-space: nowrap;">' + mon4t5 + ' - ' + gv4t5 + '</a>';
                if (j == 24 && malop == lop4t5 && cell == (stt + 1)) {
                    $('#tkb tr:eq(24) td:eq(' + (cell - 1) + ')').html(thu4t5).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t5.filter(function(number) {
                var gv5t5 = number.hovatengv;
                var mon5t5 = number.tenmon;
                var lop5t5 = number.malop;
                var thu5t5 = '<a style="white-space: nowrap;">' + mon5t5 + ' - ' + gv5t5 + '</a>';
                if (j == 34 && malop == lop5t5 && cell == (stt + 1)) {
                    $('#tkb tr:eq(34) td:eq(' + (cell - 1) + ')').html(thu5t5).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t5.filter(function(number) {
                var gv6t5 = number.hovatengv;
                var mon6t5 = number.tenmon;
                var lop6t5 = number.malop;
                var thu6t5 = '<a style="white-space: nowrap;">' + mon6t5 + ' - ' + gv6t5 + '</a>';
                if (j == 44 && malop == lop6t5 && cell == (stt + 1)) {
                    $('#tkb tr:eq(44) td:eq(' + (cell - 1) + ')').html(thu6t5).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t5.filter(function(number) {
                var gv7t5 = number.hovatengv;
                var mon7t5 = number.tenmon;
                var lop7t5 = number.malop;
                var thu7t5 = '<a style="white-space: nowrap;">' + mon7t5 + ' - ' + gv7t5 + '</a>';
                if (j == 54 && malop == lop7t5 && cell == (stt + 1)) {
                    $('#tkb tr:eq(54) td:eq(' + (cell - 1) + ')').html(thu7t5).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 6
            lucky2t6.filter(function(number) {
                var gv2t6 = number.hovatengv;
                var mon2t6 = number.tenmon;
                var lop2t6 = number.malop;
                var thu2t6 = '<a style="white-space: nowrap;">' + mon2t6 + ' - ' + gv2t6 + '</a>';
                if (j == 5 && malop == lop2t6 && cell == (stt + 1)) {
                    $('#tkb tr:eq(5) td:eq(' + (cell) + ')').html(thu2t6).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t6.filter(function(number) {
                var gv3t6 = number.hovatengv;
                var mon3t6 = number.tenmon;
                var lop3t6 = number.malop;
                var thu3t6 = '<a style="white-space: nowrap;">' + mon3t6 + ' - ' + gv3t6 + '</a>';
                if (j == 15 && malop == lop3t6 && cell == (stt + 1)) {
                    $('#tkb tr:eq(15) td:eq(' + (cell) + ')').html(thu3t6).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t6.filter(function(number) {
                var gv4t6 = number.hovatengv;
                var mon4t6 = number.tenmon;
                var lop4t6 = number.malop;
                var thu4t6 = '<a style="white-space: nowrap;">' + mon4t6 + ' - ' + gv4t6 + '</a>';
                if (j == 25 && malop == lop4t6 && cell == (stt + 1)) {
                    $('#tkb tr:eq(25) td:eq(' + (cell - 1) + ')').html(thu4t6).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t6.filter(function(number) {
                var gv5t6 = number.hovatengv;
                var mon5t6 = number.tenmon;
                var lop5t6 = number.malop;
                var thu5t6 = '<a style="white-space: nowrap;">' + mon5t6 + ' - ' + gv5t6 + '</a>';
                if (j == 35 && malop == lop5t6 && cell == (stt + 1)) {
                    $('#tkb tr:eq(35) td:eq(' + (cell - 1) + ')').html(thu5t6).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t6.filter(function(number) {
                var gv6t6 = number.hovatengv;
                var mon6t6 = number.tenmon;
                var lop6t6 = number.malop;
                var thu6t6 = '<a style="white-space: nowrap;">' + mon6t6 + ' - ' + gv6t6 + '</a>';
                if (j == 45 && malop == lop6t6 && cell == (stt + 1)) {
                    $('#tkb tr:eq(45) td:eq(' + (cell - 1) + ')').html(thu6t6).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t6.filter(function(number) {
                var gv7t6 = number.hovatengv;
                var mon7t6 = number.tenmon;
                var lop7t6 = number.malop;
                var thu7t6 = '<a style="white-space: nowrap;">' + mon7t6 + ' - ' + gv7t6 + '</a>';
                if (j == 55 && malop == lop7t6 && cell == (stt + 1)) {
                    $('#tkb tr:eq(55) td:eq(' + (cell) + ')').html(thu7t6).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 7
            lucky2t7.filter(function(number) {
                var gv2t7 = number.hovatengv;
                var mon2t7 = number.tenmon;
                var lop2t7 = number.malop;
                var thu2t7 = '<a style="white-space: nowrap;">' + mon2t7 + ' - ' + gv2t7 + '</a>';
                if (j == 6 && malop == lop2t7 && cell == (stt + 1)) {
                    $('#tkb tr:eq(6) td:eq(' + (cell - 1) + ')').html(thu2t7).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t7.filter(function(number) {
                var gv3t7 = number.hovatengv;
                var mon3t7 = number.tenmon;
                var lop3t7 = number.malop;
                var thu3t7 = '<a style="white-space: nowrap;">' + mon3t7 + ' - ' + gv3t7 + '</a>';
                if (j == 16 && malop == lop3t7 && cell == (stt + 1)) {
                    $('#tkb tr:eq(16) td:eq(' + (cell - 1) + ')').html(thu3t7).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t7.filter(function(number) {
                var gv4t7 = number.hovatengv;
                var mon4t7 = number.tenmon;
                var lop4t7 = number.malop;
                var thu4t7 = '<a style="white-space: nowrap;">' + mon4t7 + ' - ' + gv4t7 + '</a>';
                if (j == 26 && malop == lop4t7 && cell == (stt + 1)) {
                    $('#tkb tr:eq(26) td:eq(' + (cell - 1) + ')').html(thu4t7).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t7.filter(function(number) {
                var gv5t7 = number.hovatengv;
                var mon5t7 = number.tenmon;
                var lop5t7 = number.malop;
                var thu5t7 = '<a style="white-space: nowrap;">' + mon5t7 + ' - ' + gv5t7 + '</a>';
                if (j == 36 && malop == lop5t7 && cell == (stt + 1)) {
                    $('#tkb tr:eq(36) td:eq(' + (cell - 1) + ')').html(thu5t7).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t7.filter(function(number) {
                var gv6t7 = number.hovatengv;
                var mon6t7 = number.tenmon;
                var lop6t7 = number.malop;
                var thu6t7 = '<a style="white-space: nowrap;">' + mon6t7 + ' - ' + gv6t7 + '</a>';
                if (j == 46 && malop == lop6t7 && cell == (stt + 1)) {
                    $('#tkb tr:eq(46) td:eq(' + (cell - 1) + ')').html(thu6t7).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t7.filter(function(number) {
                var gv7t7 = number.hovatengv;
                var mon7t7 = number.tenmon;
                var lop7t7 = number.malop;
                var thu7t7 = '<a style="white-space: nowrap;">' + mon7t7 + ' - ' + gv7t7 + '</a>';
                if (j == 56 && malop == lop7t7 && cell == (stt + 1)) {
                    $('#tkb tr:eq(56) td:eq(' + (cell - 1) + ')').html(thu7t7).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 8
            lucky2t8.filter(function(number) {
                var gv2t8 = number.hovatengv;
                var mon2t8 = number.tenmon;
                var lop2t8 = number.malop;
                var thu2t8 = '<a style="white-space: nowrap;">' + mon2t8 + ' - ' + gv2t8 + '</a>';
                if (j == 7 && malop == lop2t8 && cell == (stt + 1)) {
                    $('#tkb tr:eq(7) td:eq(' + (cell - 1) + ')').html(thu2t8).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t8.filter(function(number) {
                var gv3t8 = number.hovatengv;
                var mon3t8 = number.tenmon;
                var lop3t8 = number.malop;
                var thu3t8 = '<a style="white-space: nowrap;">' + mon3t8 + ' - ' + gv3t8 + '</a>';
                if (j == 17 && malop == lop3t8 && cell == (stt + 1)) {
                    $('#tkb tr:eq(17) td:eq(' + (cell - 1) + ')').html(thu3t8).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t8.filter(function(number) {
                var gv4t8 = number.hovatengv;
                var mon4t8 = number.tenmon;
                var lop4t8 = number.malop;
                var thu4t8 = '<a style="white-space: nowrap;">' + mon4t8 + ' - ' + gv4t8 + '</a>';
                if (j == 27 && malop == lop4t8 && cell == (stt + 1)) {
                    $('#tkb tr:eq(27) td:eq(' + (cell - 1) + ')').html(thu4t8).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t8.filter(function(number) {
                var gv5t8 = number.hovatengv;
                var mon5t8 = number.tenmon;
                var lop5t8 = number.malop;
                var thu5t8 = '<a style="white-space: nowrap;">' + mon5t8 + ' - ' + gv5t8 + '</a>';
                if (j == 37 && malop == lop5t8 && cell == (stt + 1)) {
                    $('#tkb tr:eq(37) td:eq(' + (cell - 1) + ')').html(thu5t8).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t8.filter(function(number) {
                var gv6t8 = number.hovatengv;
                var mon6t8 = number.tenmon;
                var lop6t8 = number.malop;
                var thu6t8 = '<a style="white-space: nowrap;">' + mon6t8 + ' - ' + gv6t8 + '</a>';
                if (j == 47 && malop == lop6t8 && cell == (stt + 1)) {
                    $('#tkb tr:eq(47) td:eq(' + (cell - 1) + ')').html(thu6t8).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t8.filter(function(number) {
                var gv7t8 = number.hovatengv;
                var mon7t8 = number.tenmon;
                var lop7t8 = number.malop;
                var thu7t8 = '<a style="white-space: nowrap;">' + mon7t8 + ' - ' + gv7t8 + '</a>';
                if (j == 57 && malop == lop7t8 && cell == (stt + 1)) {
                    $('#tkb tr:eq(57) td:eq(' + (cell - 1) + ')').html(thu7t8).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 9
            lucky2t9.filter(function(number) {
                var gv2t9 = number.hovatengv;
                var mon2t9 = number.tenmon;
                var lop2t9 = number.malop;
                var thu2t9 = '<a style="white-space: nowrap;">' + mon2t9 + ' - ' + gv2t9 + '</a>';
                if (j == 8 && malop == lop2t9 && cell == (stt + 1)) {
                    $('#tkb tr:eq(8) td:eq(' + (cell - 1) + ')').html(thu2t9).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t9.filter(function(number) {
                var gv3t9 = number.hovatengv;
                var mon3t9 = number.tenmon;
                var lop3t9 = number.malop;
                var thu3t9 = '<a style="white-space: nowrap;">' + mon3t9 + ' - ' + gv3t9 + '</a>';
                if (j == 18 && malop == lop3t9 && cell == (stt + 1)) {
                    $('#tkb tr:eq(18) td:eq(' + (cell - 1) + ')').html(thu3t9).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t9.filter(function(number) {
                var gv4t9 = number.hovatengv;
                var mon4t9 = number.tenmon;
                var lop4t9 = number.malop;
                var thu4t9 = '<a style="white-space: nowrap;">' + mon4t9 + ' - ' + gv4t9 + '</a>';
                if (j == 28 && malop == lop4t9 && cell == (stt + 1)) {
                    $('#tkb tr:eq(28) td:eq(' + (cell - 1) + ')').html(thu4t9).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t9.filter(function(number) {
                var gv5t9 = number.hovatengv;
                var mon5t9 = number.tenmon;
                var lop5t9 = number.malop;
                var thu5t9 = '<a style="white-space: nowrap;">' + mon5t9 + ' - ' + gv5t9 + '</a>';
                if (j == 38 && malop == lop5t9 && cell == (stt + 1)) {
                    $('#tkb tr:eq(38) td:eq(' + (cell - 1) + ')').html(thu5t9).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t9.filter(function(number) {
                var gv6t9 = number.hovatengv;
                var mon6t9 = number.tenmon;
                var lop6t9 = number.malop;
                var thu6t9 = '<a style="white-space: nowrap;">' + mon6t9 + ' - ' + gv6t9 + '</a>';
                if (j == 48 && malop == lop6t9 && cell == (stt + 1)) {
                    $('#tkb tr:eq(48) td:eq(' + (cell - 1) + ')').html(thu6t9).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t9.filter(function(number) {
                var gv7t9 = number.hovatengv;
                var mon7t9 = number.tenmon;
                var lop7t9 = number.malop;
                var thu7t9 = '<a style="white-space: nowrap;">' + mon7t9 + ' - ' + gv7t9 + '</a>';
                if (j == 58 && malop == lop7t9 && cell == (stt + 1)) {
                    $('#tkb tr:eq(58) td:eq(' + (cell - 1) + ')').html(thu7t9).attr('style','border: 1px solid #ddd;');
                }
            })

            //tiet 10
            lucky2t10.filter(function(number) {
                var gv2t10 = number.hovatengv;
                var mon2t10 = number.tenmon;
                var lop2t10 = number.malop;
                var thu2t10 = '<a style="white-space: nowrap;">' + mon2t10 + ' - ' + gv2t10 + '</a>';
                if (j == 9 && malop == lop2t10 && cell == (stt + 1)) {
                    $('#tkb tr:eq(9) td:eq(' + (cell - 1) + ')').html(thu2t10).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky3t10.filter(function(number) {
                var gv3t10 = number.hovatengv;
                var mon3t10 = number.tenmon;
                var lop3t10 = number.malop;
                var thu3t10 = '<a style="white-space: nowrap;">' + mon3t10 + ' - ' + gv3t10 + '</a>';
                if (j == 19 && malop == lop3t10 && cell == (stt + 1)) {
                    $('#tkb tr:eq(19) td:eq(' + (cell - 1) + ')').html(thu3t10).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky4t10.filter(function(number) {
                var gv4t10 = number.hovatengv;
                var mon4t10 = number.tenmon;
                var lop4t10 = number.malop;
                var thu4t10 = '<a style="white-space: nowrap;">' + mon4t10 + ' - ' + gv4t10 + '</a>';
                if (j == 29 && malop == lop4t10 && cell == (stt + 1)) {
                    $('#tkb tr:eq(29) td:eq(' + (cell - 1) + ')').html(thu4t10).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky5t10.filter(function(number) {
                var gv5t10 = number.hovatengv;
                var mon5t10 = number.tenmon;
                var lop5t10 = number.malop;
                var thu5t10 = '<a style="white-space: nowrap;">' + mon5t10 + ' - ' + gv5t10 + '</a>';
                if (j == 39 && malop == lop5t10 && cell == (stt + 1)) {
                    $('#tkb tr:eq(39) td:eq(' + (cell - 1) + ')').html(thu5t10).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky6t10.filter(function(number) {
                var gv6t10 = number.hovatengv;
                var mon6t10 = number.tenmon;
                var lop6t10 = number.malop;
                var thu6t10 = '<a style="white-space: nowrap;">' + mon6t10 + ' - ' + gv6t10 + '</a>';
                if (j == 49 && malop == lop6t10 && cell == (stt + 1)) {
                    $('#tkb tr:eq(49) td:eq(' + (cell - 1) + ')').html(thu6t10).attr('style','border: 1px solid #ddd;');
                }
            })
            lucky7t10.filter(function(number) {
                var gv7t10 = number.hovatengv;
                var mon7t10 = number.tenmon;
                var lop7t10 = number.malop;
                var thu7t10 = '<a style="white-space: nowrap;">' + mon7t10 + ' - ' + gv7t10 + '</a>';
                if (j == 59 && malop == lop7t10 && cell == (stt + 1)) {
                    $('#tkb tr:eq(59) td:eq(' + (cell - 1) + ')').html(thu7t10).attr('style','border: 1px solid #ddd;');
                }
            })





        }
    }

    var table = $('#example').DataTable({
        // pageLength: 3,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        "searching": false,
        "retrieve": true,
        "bStateSave": true,
        "bSort": false,


        drawCallback: function() {
            // Apply HTML5 drag and drop listeners to all cells
            cells = document.querySelectorAll('#example td');
            [].forEach.call(cells, function(cell) {
                cell.addEventListener('dragstart', handleDragStart, false);
                cell.addEventListener('dragenter', handleDragEnter, false)
                cell.addEventListener('dragover', handleDragOver, false);
                cell.addEventListener('dragleave', handleDragLeave, false);
                cell.addEventListener('drop', handleDrop, false);
                cell.addEventListener('dragend', handleDragEnd, false);
            });
        }

    });
    lblVongthu.textContent = data.vong;
    // console.log(datatkb);
}

function btncapnhattkb(){
   let datas = datatkb;
   var datastkb = [];
    //t2 tiet 1
    let lucky2t1 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky2t1);
    //t3 tiet 1
    let lucky3t1 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky3t1);
    //t4 tiet 1
    let lucky4t1 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky4t1);
    //t5 tiet 1
    let lucky5t1 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky5t1);
    //t6 tiet 1
    let lucky6t1 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky6t1);
    //t7 tiet 1
    let lucky7t1 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky7t1);


    //t2 tiet 2
    let lucky2t2 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky2t2);
    //t3 tiet 2
    let lucky3t2 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky3t2);
    //t4 tiet 2
    let lucky4t2 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky4t2);
    //t5 tiet 2
    let lucky5t2 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky5t2);
    //t6 tiet 2
    let lucky6t2 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky6t2);
    //t7 tiet 2
    let lucky7t2 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky7t2);


    //t2 tiet 3
    let lucky2t3 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky2t3);
    //t3 tiet 3
    let lucky3t3 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky3t3);
    //t4 tiet 3
    let lucky4t3 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky4t3);
    //t5 tiet 3
    let lucky5t3 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky5t3);
    //t6 tiet 3
    let lucky6t3 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky6t3);
    //t7 tiet 3
    let lucky7t3 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky7t3);


    //t2 tiet 4
    let lucky2t4 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky2t4);
    //t3 tiet 4
    let lucky3t4 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky3t4);
    //t4 tiet 4
    let lucky4t4 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky4t4);
    //t5 tiet 4
    let lucky5t4 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky5t4);
    //t6 tiet 4
    let lucky6t4 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky6t4);
    //t7 tiet 4
    let lucky7t4 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky7t4);


    //t2 tiet 5
    let lucky2t5 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky2t5);
    //t3 tiet 5
    let lucky3t5 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky3t5);
    //t4 tiet 5
    let lucky4t5 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky4t5);
    //t5 tiet 5
    let lucky5t5 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky5t5);
    //t6 tiet 5
    let lucky6t5 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky6t5);
    //t7 tiet 5
    let lucky7t5 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky7t5);


    //t2 tiet 6
    let lucky2t6 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky2t6);
    //t3 tiet 6
    let lucky3t6 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky3t6);
    //t4 tiet 6
    let lucky4t6 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky4t6);
    //t5 tiet 6
    let lucky5t6 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky5t6);
    //t6 tiet 6
    let lucky6t6 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky6t6);
    //t7 tiet 6
    let lucky7t6 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 1) {
            return number;
        }
    });
    datastkb.push(lucky7t6);


    //t2 tiet 7
    let lucky2t7 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky2t7);
    //t3 tiet 7
    let lucky3t7 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky3t7);
    //t4 tiet 7
    let lucky4t7 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky4t7);
    //t5 tiet 7
    let lucky5t7 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky5t7);
    //t6 tiet 7
    let lucky6t7 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky6t7);
    //t7 tiet 7
    let lucky7t7 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 2) {
            return number;
        }
    });
    datastkb.push(lucky7t7);


    //t2 tiet 8
    let lucky2t8 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky2t8);
    //t3 tiet 8
    let lucky3t8 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky3t8);
    //t4 tiet 8
    let lucky4t8 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky4t8);
    //t5 tiet 8
    let lucky5t8 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky5t8);
    //t6 tiet 8
    let lucky6t8 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky6t8);
    //t7 tiet 8
    let lucky7t8 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 3) {
            return number;
        }
    });
    datastkb.push(lucky7t8);


    //t2 tiet 9
    let lucky2t9 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky2t9);
    //t3 tiet 9
    let lucky3t9 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky3t9);
    //t4 tiet 9
    let lucky4t9 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky4t9);
    //t5 tiet 9
    let lucky5t9 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky5t9);
    //t6 tiet 9
    let lucky6t9 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky6t9);
    //t7 tiet 9
    let lucky7t9 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 4) {
            return number;
        }
    });
    datastkb.push(lucky7t9);


    //t2 tiet 10
    let lucky2t10 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky2t10);
    //t3 tiet 10
    let lucky3t10 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky3t10);
    //t4 tiet 10
    let lucky4t10 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky4t10);
    //t5 tiet 10
    let lucky5t10 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky5t10);
    //t6 tiet 10
    let lucky6t10 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky6t10);
    //t7 tiet 10
    let lucky7t10 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 5) {
            return number;
        }
    });
    datastkb.push(lucky7t10);

    var locdata = datastkb.filter(function(number) {
        if (number != "") {
            return number;
        }
    });

    axios.post('capnhatthoikhoabieu',locdata).then(function (response) {
        var status = response.status;
						Swal.fire({
					title: 'Lưu',
					text: 'Đã lưu thành công',
					icon: 'success',
					confirmButtonText: 'OK'
				});
    });
}

function TaoTd(giatri) {
    let td = document.createElement("td");
    let text = document.createTextNode(giatri);
    td.appendChild(text);
    return td;
}

// Ham dung xep thoi khoa bieu
function dungxepTKB() {
    clearInterval(thoigianchay);
    // Dung tien trinh chay nen da duoc tao ra
    Tientrinhxepthoikhoabieu.terminate();
}

function setRangbuoc() {
    arrrangbuoc = $("#girddsrangbuoc")
    .dxDataGrid("instance")
    .getSelectedRowsData();
}

function setdsgiaovien() {
    arrGiaovien = $("#girddsgv").dxDataGrid("instance").getSelectedRowsData('All');
}

function setdslophoc() {
    arrLophoc = $("#girddslophoc").dxDataGrid("instance").getSelectedRowsData();
}

function setdsphonghoc() {
    arrPhonghoc = $("#girddsphonghoc")
    .dxDataGrid("instance")
    .getSelectedRowsData();
}

setTimeout(function() {
    $("#changegv").trigger("click");
}, 500);

setTimeout(function() {
    $("#girddsrangbuoc").trigger("click");
    danhsachrangbuoc();
}, 500);



$("#changegv").change(function() {
    if ($(this).is(":checked")) {
        $("#changelophoc").prop("checked", false);
        $("#changephonghoc").prop("checked", false);
        document.getElementById("girddslophoc").style.display = "none";
        document.getElementById("girddsgv").style.display = "block";
        document.getElementById("girddsphonghoc").style.display = "none";
        danhsachgv();
    }
});

$("#changelophoc").change(function() {
    if ($(this).is(":checked")) {
        $("#changegv").prop("checked", false);
        $("#changephonghoc").prop("checked", false);
        document.getElementById("girddslophoc").style.display = "block";
        document.getElementById("girddsgv").style.display = "none";
        document.getElementById("girddsphonghoc").style.display = "none";
        // chkChontatca.checked = false;
        danhsachlophoc();
    }
});

$("#changephonghoc").change(function() {
    if ($(this).is(":checked")) {
        $("#changelophoc").prop("checked", false);
        $("#changegv").prop("checked", false);
        document.getElementById("girddslophoc").style.display = "none";
        document.getElementById("girddsgv").style.display = "none";
        document.getElementById("girddsphonghoc").style.display = "block";
        danhsachphonghoc();
        // chkChontatca.checked = false;
    }
});

$("#tinhchinhrangbuoc").click(function() {
    document.getElementById("cardtkb").style.display = "none";
    document.getElementById("rowtcrangbuoc").style.display = "block";
    document.getElementById("cardtcrangbuoc").style.display = "block";
    tcrangbuoc();
});
$("#tcrangbuocclose").click(function() {
    document.getElementById("rowtcrangbuoc").style.display = "none";
    document.getElementById("cardtcrangbuoc").style.display = "none";
    document.getElementById("cardtkb").style.display = "block";
});
$("#btnxemtkb").click(function() {
    document.getElementById("cardxeptkb").style.display = "block";
});
$("#closexemtkb").click(function() {
    document.getElementById("cardxeptkb").style.display = "none";
});




function danhsachgv() {
    var data = axios.get('getdanhsachgv').then(function(response) {
        var data1 = response.data;
        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });
        $("#girddsgv").dxDataGrid({
            dataSource: datas,
            showBorders: true,
            scrolling: {
                mode: "virtual",
                rowRenderingMode: "virtual"
            },
            /* xap xep */
            sorting: {
                mode: "multiple"
            },
            height: 500,
            /* loc du lieu */
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            /*chon row*/
            selection: {
                mode: "single",
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                caption: "Tên",
                dataField: "hovaten",
            }],
            // select data row
            onSelectionChanged: function(selectedItems) {
                var data = selectedItems.selectedRowsData[0];
                idgiaovien = data.id;
                tengiaovien = data.ten;
            },
        });
    });
}



function danhsachlophoc() {
    var data = axios.get('getdanhsachlophoc').then(function(response) {
        var data1 = response.data;
        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });
        $("#girddslophoc").dxDataGrid({
            dataSource: datas,
            showBorders: true,
            keyExpr: "id",
            scrolling: {
                mode: "virtual",
                rowRenderingMode: "virtual"
            },
            /* xap xep */
            sorting: {
                mode: "multiple"
            },
            height: 500,
            /* loc du lieu */
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            /*chon row*/
            selection: {
                mode: "single",
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                caption: "Tên lớp",
                dataField: "tenlop",
            }],
            selectedRowKeys: [1],
            // select data row
            onSelectionChanged: function(selectedItems) {
                var data = selectedItems.selectedRowsData[0];
                idlop = data.id;
            },
        });
        var dataGrid = $("#girddslophoc").dxDataGrid("instance");
        var selectedKeys = dataGrid.getSelectedRowKeys();
        idlop = selectedKeys[0];
    });
}



function danhsachphonghoc() {
    var data = axios.get('getdanhsachphonghocbomon').then(function(response) {
        var data1 = response.data;
        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });
        $("#girddsphonghoc").dxDataGrid({
            dataSource: datas,
            showBorders: true,
            scrolling: {
                mode: "virtual",
                rowRenderingMode: "virtual"
            },
            /* xap xep */
            sorting: {
                mode: "multiple"
            },
            height: 500,
            /* loc du lieu */
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            /*chon row*/
            selection: {
                mode: "single",
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                caption: "Tên phòng học",
                dataField: "tenphong",
            }],
            // select data row
            onSelectionChanged: function(selectedItems) {

            },
        });
    });
}



function danhsachrangbuoc() {
    var data = axios.get('getlistdanhsachrangbuoc').then(function(response) {
        var data1 = response.data;
        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });


        $("#girddsrangbuoc").dxDataGrid({
            dataSource: datas,
            remoteOperations: true,
            showBorders: true,
            loadPanel: {
                enabled: true
            },

            scrolling: {
                mode: 'infinite'
                    // rowRenderingMode: "virtual"
                },
                height: 500,
            // paging: {
            //     pageSize: 10
            // },
            wordWrapEnabled: true,
            /* xap xep */
            sorting: {
                mode: "multiple",

            },
            /* loc du lieu */
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            /*chon row*/
            selection: {
                mode: "multiple",
                // deferred: true
            },
            // selectionFilter: ["tenrangbuoc", "=", "Completed"],
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                caption: "Tên ràng buộc",
                dataField: "tenrangbuoc",
            }],
            onSelectionChanged: function(selectedItems) {

            }
        });
        var dataGrid = $("#girddsrangbuoc").dxDataGrid("instance");
        var dataall = dataGrid.selectAll();

    });
}



function tcrangbuoc() {
    var data = axios.get('getlistdanhsachrangbuoc').then(function(response) {
        var data1 = response.data;
        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });

        $("#girdtcrangbuoc").dxDataGrid({
            dataSource: datas,
            remoteOperations: true,
            showBorders: true,
            loadPanel: {
                enabled: true
            },
            scrolling: {
                mode: 'infinite'
                    // rowRenderingMode: "virtual"
                },
                height: 700,
                editing: {
                    mode: "batch",
                    allowUpdating: true,
                    selectTextOnEditStart: true,
                    startEditAction: "click"
                    // allowDeleting: true,
                    // allowAdding: true
                },
            // paging: {
            //     pageSize: 10
            // },
            wordWrapEnabled: true,
            /* xap xep */
            sorting: {
                mode: "none"
            },
            /* loc du lieu */
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            /*chon row*/
            selection: {
                mode: "multiple",
                recursive: true
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                caption: "Ràng buộc  (Hãy chọn/bỏ hoặc điều chỉnh điểm cho mỗi ràng buộc theo yêu cầu TKB của bạn)",
                dataField: "tenrangbuoc",
                allowEditing: false,
                width: 200
            }, {
                caption: "Điểm trừ vi phạm ràng buộc ở các mức (Điểm càng cao thì ràng buộc càng được ưu tiên)",
                columns: [{
                    caption: "Điểm trừ mức 1",
                    dataField: "muc1",
                }, {
                    caption: "Điểm trừ mức 2",
                    dataField: "muc2",
                }, {
                    caption: "Điểm trừ mức 3",
                    dataField: "muc3",
                }]
            }],
            // select data row
            onSelectionChanged: function(selectedItems) {

            },
            onRowUpdating: function(e) {
                var key = e.key.id;
                var muc1 = e.key.muc1;
                if (muc1 == null) {
                    var muc1 = e.newData.muc1;
                }
                var muc2 = e.key.muc2;
                if (muc2 == null) {
                    var muc2 = e.newData.muc2;
                }
                var muc3 = e.key.muc3;
                if (muc3 == null) {
                    var muc3 = e.newData.muc3;
                }

                axios.post('uptcrangbuoc', {
                    id: key,
                    muc1: muc1,
                    muc2: muc2,
                    muc3: muc3
                }).then(function(response) {
                    var data = response.data;
                    Swal.fire({
                        title: 'Lưu',
                        text: 'Đã lưu thành công',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    var dataGrid = $("#girdtcrangbuoc").dxDataGrid("instance");
                    dataGrid.refresh();
                });
            },
        });
    });
}



var tengiaovien;
function thoikhoabieugiaovien(idgiaovien, thoikhoabieu) {
    $('#titletkbgv').html('Thời khóa biểu giáo viên: '+tengiaovien);
    var tkbtemp = [];
    document.getElementById("cardxeptkbgv").style.display = "block";
    let index = 0;
    for (let thu = 2; thu < 8; thu++) {
        for (let tiet = 1; tiet < 11; tiet++) {
            // chỗ này sử dụng phương thức gán vào mảng đã có chứ ko push
            if (thoikhoabieu[index].magiaovien == idgiaovien) {
                tkbtemp.push(thoikhoabieu[index]);
            }
            index++;
        }
    }

    var datas = tkbtemp;

    //tiet 1
    let lucky2t1 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky3t1 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky4t1 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky5t1 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky6t1 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky7t1 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });

    //tiet 2
    let lucky2t2 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky3t2 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky4t2 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky5t2 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky6t2 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky7t2 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });


    //tiet 3
    let lucky2t3 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky3t3 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky4t3 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky5t3 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky6t3 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky7t3 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });


    //tiet 4
    let lucky2t4 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });

    let lucky3t4 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });

    let lucky4t4 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    let lucky5t4 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    let lucky6t4 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    let lucky7t4 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });

    //tiet 5
    let lucky2t5 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky3t5 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky4t5 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky5t5 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky6t5 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky7t5 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });


    //tiet 6
    let lucky2t6 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky3t6 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky4t6 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky5t6 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky6t6 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky7t6 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });


    //tiet 7
    let lucky2t7 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky3t7 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });
    let lucky4t7 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });
    let lucky5t7 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });
    let lucky6t7 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });
    let lucky7t7 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });


    //tiet 8
    let lucky2t8 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky3t8 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky4t8 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky5t8 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky6t8 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky7t8 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });


    //tiet 9
    let lucky2t9 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky3t9 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky4t9 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky5t9 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky6t9 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky7t9 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });


    //tiet 10
    let lucky2t10 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky3t10 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky4t10 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky5t10 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky6t10 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky7t10 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    
    
    
    //t2 tiet 1
    var thu2t1 = [];
    lucky2t1.filter(function(number) {
        var mon2t1 = number.tenmon;
        var lop2t1 = number.tenlop;
        var thu2t1s = '<a draggable="true">'+mon2t1 + ' - ' + lop2t1 + '</a><br>';
        thu2t1.push(thu2t1s);        
    });
    $('#tkbgv tr:eq(0) td:eq(2)').html(thu2t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 1
    var thu3t1 = [];
    lucky3t1.filter(function(number) {
        var mon3t1 = number.tenmon;
        var lop3t1 = number.tenlop;
        var thu3t1s = '<a draggable="true">'+mon3t1 + ' - ' + lop3t1 + '</a><br>';
        thu3t1.push(thu3t1s);        
    });
    $('#tkbgv tr:eq(0) td:eq(3)').html(thu3t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 1
    var thu4t1 = [];
    lucky4t1.filter(function(number) {
        var mon4t1 = number.tenmon;
        var lop4t1 = number.tenlop;
        var thu4t1s = '<a draggable="true">'+mon4t1 + ' - ' + lop4t1 + '</a><br>';
        thu4t1.push(thu4t1s);        
    });
    $('#tkbgv tr:eq(0) td:eq(4)').html(thu4t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 1
    var thu5t1 = [];
    lucky5t1.filter(function(number) {
        var mon5t1 = number.tenmon;
        var lop5t1 = number.tenlop;
        var thu5t1s = '<a draggable="true">'+mon5t1 + ' - ' + lop5t1 + '</a><br>';
        thu5t1.push(thu5t1s);        
    });
    $('#tkbgv tr:eq(0) td:eq(5)').html(thu5t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 1
    var thu6t1 = [];
    lucky6t1.filter(function(number) {
        var mon6t1 = number.tenmon;
        var lop6t1 = number.tenlop;
        var thu6t1s = '<a draggable="true">'+mon6t1 + ' - ' + lop6t1 + '</a><br>';
        thu6t1.push(thu6t1s);        
    });
    $('#tkbgv tr:eq(0) td:eq(6)').html(thu6t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 1
    var thu7t1 = [];
    lucky7t1.filter(function(number) {
        var mon7t1 = number.tenmon;
        var lop7t1 = number.tenlop;
        var thu7t1s = '<a draggable="true">'+mon7t1 + ' - ' + lop7t1 + '</a><br>';
        thu7t1.push(thu7t1s);        
    });
    $('#tkbgv tr:eq(0) td:eq(7)').html(thu7t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 2
    var thu2t2 = [];
    lucky2t2.filter(function(number) {
        var mon2t2 = number.tenmon;
        var lop2t2 = number.tenlop;
        var thu2t2s = '<a draggable="true">'+mon2t2 + ' - ' + lop2t2 + '</a><br>';
        thu2t2.push(thu2t2s);        
    });
    $('#tkbgv tr:eq(1) td:eq(2)').html(thu2t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t2 = [];
    lucky3t2.filter(function(number) {
        var mon3t2 = number.tenmon;
        var lop3t2 = number.tenlop;
        var thu3t2s = '<a draggable="true">'+mon3t2 + ' - ' + lop3t2 + '</a><br>';
        thu3t2.push(thu3t2s);        
    });
    $('#tkbgv tr:eq(1) td:eq(3)').html(thu3t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t2 = [];
    lucky4t2.filter(function(number) {
        var mon4t2 = number.tenmon;
        var lop4t2 = number.tenlop;
        var thu4t2s = '<a draggable="true">'+mon4t2 + ' - ' + lop4t2 + '</a><br>';
        thu4t2.push(thu4t2s);        
    });
    $('#tkbgv tr:eq(1) td:eq(4)').html(thu4t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t2 = [];
    lucky5t2.filter(function(number) {
        var mon5t2 = number.tenmon;
        var lop5t2 = number.tenlop;
        var thu5t2s = '<a draggable="true">'+mon5t2 + ' - ' + lop5t2 + '</a><br>';
        thu5t2.push(thu5t2s);        
    });
    $('#tkbgv tr:eq(1) td:eq(5)').html(thu5t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t2 = [];
    lucky6t2.filter(function(number) {
        var mon6t2 = number.tenmon;
        var lop6t2 = number.tenlop;
        var thu6t2s = '<a draggable="true">'+mon6t2 + ' - ' + lop6t2 + '</a><br>';
        thu6t2.push(thu6t2s);        
    });
    $('#tkbgv tr:eq(1) td:eq(6)').html(thu6t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t2 = [];
    lucky7t2.filter(function(number) {
        var mon7t2 = number.tenmon;
        var lop7t2 = number.tenlop;
        var thu7t2s = '<a draggable="true">'+mon7t2 + ' - ' + lop7t2 + '</a><br>';
        thu7t2.push(thu7t2s);        
    });
    $('#tkbgv tr:eq(1) td:eq(7)').html(thu7t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 3
    var thu2t3 = [];
    lucky2t3.filter(function(number) {
        var mon2t3 = number.tenmon;
        var lop2t3 = number.tenlop;
        var thu2t3s = '<a draggable="true">'+mon2t3 + ' - ' + lop2t3 + '</a><br>';
        thu2t3.push(thu2t3s);        
    });
    $('#tkbgv tr:eq(2) td:eq(2)').html(thu2t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 3
    var thu3t3 = [];
    lucky3t3.filter(function(number) {
        var mon3t3 = number.tenmon;
        var lop3t3 = number.tenlop;
        var thu3t3s = '<a draggable="true">'+mon3t3 + ' - ' + lop3t3 + '</a><br>';
        thu3t3.push(thu3t3s);        
    });
    $('#tkbgv tr:eq(2) td:eq(3)').html(thu3t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 3
    var thu4t3 = [];
    lucky4t3.filter(function(number) {
        var mon4t3 = number.tenmon;
        var lop4t3 = number.tenlop;
        var thu4t3s = '<a draggable="true">'+mon4t3 + ' - ' + lop4t3 + '</a><br>';
        thu4t3.push(thu4t3s);        
    });
    $('#tkbgv tr:eq(2) td:eq(4)').html(thu4t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 3
    var thu5t3 = [];
    lucky5t3.filter(function(number) {
        var mon5t3 = number.tenmon;
        var lop5t3 = number.tenlop;
        var thu5t3s = '<a draggable="true">'+mon5t3 + ' - ' + lop5t3 + '</a><br>';
        thu5t3.push(thu5t3s);        
    });
    $('#tkbgv tr:eq(2) td:eq(5)').html(thu5t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 3
    var thu6t3 = [];
    lucky6t3.filter(function(number) {
        var mon6t3 = number.tenmon;
        var lop6t3 = number.tenlop;
        var thu6t3s = '<a draggable="true">'+mon6t3 + ' - ' + lop6t3 + '</a><br>';
        thu6t3.push(thu6t3s);        
    });
    $('#tkbgv tr:eq(2) td:eq(6)').html(thu6t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 3
    var thu7t3 = [];
    lucky7t3.filter(function(number) {
        var mon7t3 = number.tenmon;
        var lop7t3 = number.tenlop;
        var thu7t3s = '<a draggable="true">'+mon7t3 + ' - ' + lop7t3 + '</a><br>';
        thu7t3.push(thu7t3s);        
    });
    $('#tkbgv tr:eq(2) td:eq(7)').html(thu7t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 4
    var thu2t4 = [];
    lucky2t4.filter(function(number) {
        var mon2t4 = number.tenmon;
        var lop2t4 = number.tenlop;
        var thu2t4s = '<a draggable="true">'+mon2t4 + ' - ' + lop2t4 + '</a><br>';
        thu2t4.push(thu2t4s);        
    });
    $('#tkbgv tr:eq(3) td:eq(2)').html(thu2t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 4
    var thu3t4 = [];
    lucky3t4.filter(function(number) {
        var mon3t4 = number.tenmon;
        var lop3t4 = number.tenlop;
        var thu3t4s = '<a draggable="true">'+mon3t4 + ' - ' + lop3t4 + '</a><br>';
        thu3t4.push(thu3t4s);        
    });
    $('#tkbgv tr:eq(3) td:eq(3)').html(thu3t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 4
    var thu4t4 = [];
    lucky4t4.filter(function(number) {
        var mon4t4 = number.tenmon;
        var lop4t4 = number.tenlop;
        var thu4t4s = '<a draggable="true">'+mon4t4 + ' - ' + lop4t4 + '</a><br>';
        thu4t4.push(thu4t4s);        
    });
    $('#tkbgv tr:eq(3) td:eq(4)').html(thu4t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 4
    var thu5t4 = [];
    lucky5t4.filter(function(number) {
        var mon5t4 = number.tenmon;
        var lop5t4 = number.tenlop;
        var thu5t4s = '<a draggable="true">'+mon5t4 + ' - ' + lop5t4 + '</a><br>';
        thu5t4.push(thu5t4s);        
    });
    $('#tkbgv tr:eq(3) td:eq(5)').html(thu5t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 4
    var thu6t4 = [];
    lucky6t4.filter(function(number) {
        var mon6t4 = number.tenmon;
        var lop6t4 = number.tenlop;
        var thu6t4s = '<a draggable="true">'+mon6t4 + ' - ' + lop6t4 + '</a><br>';
        thu6t4.push(thu6t4s);        
    });
    $('#tkbgv tr:eq(3) td:eq(6)').html(thu6t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 4
    var thu7t4 = [];
    lucky7t4.filter(function(number) {
        var mon7t4 = number.tenmon;
        var lop7t4 = number.tenlop;
        var thu7t4s = '<a draggable="true">'+mon7t4 + ' - ' + lop7t4 + '</a><br>';
        thu7t4.push(thu7t4s);        
    });
    $('#tkbgv tr:eq(3) td:eq(7)').html(thu7t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 5
    var thu2t5 = [];
    lucky2t5.filter(function(number) {
        var mon2t5 = number.tenmon;
        var lop2t5 = number.tenlop;
        var thu2t5s = '<a draggable="true">'+mon2t5 + ' - ' + lop2t5 + '</a><br>';
        thu2t5.push(thu2t5s);        
    });
    $('#tkbgv tr:eq(4) td:eq(2)').html(thu2t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 5
    var thu3t5 = [];
    lucky3t5.filter(function(number) {
        var mon3t5 = number.tenmon;
        var lop3t5 = number.tenlop;
        var thu3t5s = '<a draggable="true">'+mon3t5 + ' - ' + lop3t5 + '</a><br>';
        thu3t5.push(thu3t5s);        
    });
    $('#tkbgv tr:eq(4) td:eq(3)').html(thu3t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 5
    var thu4t5 = [];
    lucky4t5.filter(function(number) {
        var mon4t5 = number.tenmon;
        var lop4t5 = number.tenlop;
        var thu4t5s = '<a draggable="true">'+mon4t5 + ' - ' + lop4t5 + '</a><br>';
        thu4t5.push(thu4t5s);        
    });
    $('#tkbgv tr:eq(4) td:eq(4)').html(thu4t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 5
    var thu5t5 = [];
    lucky5t5.filter(function(number) {
        var mon5t5 = number.tenmon;
        var lop5t5 = number.tenlop;
        var thu5t5s = '<a draggable="true">'+mon5t5 + ' - ' + lop5t5 + '</a><br>';
        thu5t5.push(thu5t5s);        
    });
    $('#tkbgv tr:eq(4) td:eq(5)').html(thu5t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 5
    var thu6t5 = [];
    lucky6t5.filter(function(number) {
        var mon6t5 = number.tenmon;
        var lop6t5 = number.tenlop;
        var thu6t5s = '<a draggable="true">'+mon6t5 + ' - ' + lop6t5 + '</a><br>';
        thu6t5.push(thu6t5s);        
    });
    $('#tkbgv tr:eq(4) td:eq(6)').html(thu6t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 5
    var thu7t5 = [];
    lucky7t5.filter(function(number) {
        var mon7t5 = number.tenmon;
        var lop7t5 = number.tenlop;
        var thu7t5s = '<a draggable="true">'+mon7t5 + ' - ' + lop7t5 + '</a><br>';
        thu7t5.push(thu7t5s);        
    });
    $('#tkbgv tr:eq(4) td:eq(7)').html(thu7t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 6
    var thu2t6 = [];
    lucky2t6.filter(function(number) {
        var mon2t6 = number.tenmon;
        var lop2t6 = number.tenlop;
        var thu2t6s = '<a draggable="true">'+mon2t6 + ' - ' + lop2t6 + '</a><br>';
        thu2t6.push(thu2t6s);        
    });
    $('#tkbgv tr:eq(5) td:eq(2)').html(thu2t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t6 = [];
    lucky3t6.filter(function(number) {
        var mon3t6 = number.tenmon;
        var lop3t6 = number.tenlop;
        var thu3t6s = '<a draggable="true">'+mon3t6 + ' - ' + lop3t6 + '</a><br>';
        thu3t6.push(thu3t6s);        
    });
    $('#tkbgv tr:eq(5) td:eq(3)').html(thu3t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t6 = [];
    lucky4t6.filter(function(number) {
        var mon4t6 = number.tenmon;
        var lop4t6 = number.tenlop;
        var thu4t6s = '<a draggable="true">'+mon4t6 + ' - ' + lop4t6 + '</a><br>';
        thu4t6.push(thu4t6s);        
    });
    $('#tkbgv tr:eq(5) td:eq(4)').html(thu4t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t6 = [];
    lucky5t6.filter(function(number) {
        var mon5t6 = number.tenmon;
        var lop5t6 = number.tenlop;
        var thu5t6s = '<a draggable="true">'+mon5t6 + ' - ' + lop5t6 + '</a><br>';
        thu5t6.push(thu5t6s);        
    });
    $('#tkbgv tr:eq(5) td:eq(5)').html(thu5t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t6 = [];
    lucky6t6.filter(function(number) {
        var mon6t6 = number.tenmon;
        var lop6t6 = number.tenlop;
        var thu6t6s = '<a draggable="true">'+mon6t6 + ' - ' + lop6t6 + '</a><br>';
        thu6t6.push(thu6t6s);        
    });
    $('#tkbgv tr:eq(5) td:eq(6)').html(thu6t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t6 = [];
    lucky7t6.filter(function(number) {
        var mon7t6 = number.tenmon;
        var lop7t6 = number.tenlop;
        var thu7t6s = '<a draggable="true">'+mon7t6 + ' - ' + lop7t6 + '</a><br>';
        thu7t6.push(thu7t6s);        
    });
    $('#tkbgv tr:eq(5) td:eq(7)').html(thu7t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 7
    var thu2t7 = [];
    lucky2t7.filter(function(number) {
        var mon2t7 = number.tenmon;
        var lop2t7 = number.tenlop;
        var thu2t7s = '<a draggable="true">'+mon2t7 + ' - ' + lop2t7 + '</a><br>';
        thu2t7.push(thu2t7s);        
    });
    $('#tkbgv tr:eq(6) td:eq(2)').html(thu2t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t7 = [];
    lucky3t7.filter(function(number) {
        var mon3t7 = number.tenmon;
        var lop3t7 = number.tenlop;
        var thu3t7s = '<a draggable="true">'+mon3t7 + ' - ' + lop3t7 + '</a><br>';
        thu3t7.push(thu3t7s);        
    });
    $('#tkbgv tr:eq(6) td:eq(3)').html(thu3t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t7 = [];
    lucky4t7.filter(function(number) {
        var mon4t7 = number.tenmon;
        var lop4t7 = number.tenlop;
        var thu4t7s = '<a draggable="true">'+mon4t7 + ' - ' + lop4t7 + '</a><br>';
        thu4t7.push(thu4t7s);        
    });
    $('#tkbgv tr:eq(6) td:eq(4)').html(thu4t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t7 = [];
    lucky5t7.filter(function(number) {
        var mon5t7 = number.tenmon;
        var lop5t7 = number.tenlop;
        var thu5t7s = '<a draggable="true">'+mon5t7 + ' - ' + lop5t7 + '</a><br>';
        thu5t7.push(thu5t7s);        
    });
    $('#tkbgv tr:eq(6) td:eq(5)').html(thu5t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t7 = [];
    lucky6t7.filter(function(number) {
        var mon6t7 = number.tenmon;
        var lop6t7 = number.tenlop;
        var thu6t7s = '<a draggable="true">'+mon6t7 + ' - ' + lop6t7 + '</a><br>';
        thu6t7.push(thu6t7s);        
    });
    $('#tkbgv tr:eq(6) td:eq(6)').html(thu6t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t7 = [];
    lucky7t7.filter(function(number) {
        var mon7t7 = number.tenmon;
        var lop7t7 = number.tenlop;
        var thu7t7s = '<a draggable="true">'+mon7t7 + ' - ' + lop7t7 + '</a><br>';
        thu7t7.push(thu7t7s);        
    });
    $('#tkbgv tr:eq(6) td:eq(7)').html(thu7t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 8
    var thu2t8 = [];
    lucky2t8.filter(function(number) {
        var mon2t8 = number.tenmon;
        var lop2t8 = number.tenlop;
        var thu2t8s = '<a draggable="true">'+mon2t8 + ' - ' + lop2t8 + '</a><br>';
        thu2t8.push(thu2t8s);        
    });
    $('#tkbgv tr:eq(7) td:eq(2)').html(thu2t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t8 = [];
    lucky3t8.filter(function(number) {
        var mon3t8 = number.tenmon;
        var lop3t8 = number.tenlop;
        var thu3t8s = '<a draggable="true">'+mon3t8 + ' - ' + lop3t8 + '</a><br>';
        thu3t8.push(thu3t8s);        
    });
    $('#tkbgv tr:eq(7) td:eq(3)').html(thu3t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t8 = [];
    lucky4t8.filter(function(number) {
        var mon4t8 = number.tenmon;
        var lop4t8 = number.tenlop;
        var thu4t8s = '<a draggable="true">'+mon4t8 + ' - ' + lop4t8 + '</a><br>';
        thu4t8.push(thu4t8s);        
    });
    $('#tkbgv tr:eq(7) td:eq(4)').html(thu4t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t8 = [];
    lucky5t8.filter(function(number) {
        var mon5t8 = number.tenmon;
        var lop5t8 = number.tenlop;
        var thu5t8s = '<a draggable="true">'+mon5t8 + ' - ' + lop5t8 + '</a><br>';
        thu5t8.push(thu5t8s);        
    });
    $('#tkbgv tr:eq(7) td:eq(5)').html(thu5t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t8 = [];
    lucky6t8.filter(function(number) {
        var mon6t8 = number.tenmon;
        var lop6t8 = number.tenlop;
        var thu6t8s = '<a draggable="true">'+mon6t8 + ' - ' + lop6t8 + '</a><br>';
        thu6t8.push(thu6t8s);        
    });
    $('#tkbgv tr:eq(7) td:eq(6)').html(thu6t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t8 = [];
    lucky7t8.filter(function(number) {
        var mon7t8 = number.tenmon;
        var lop7t8 = number.tenlop;
        var thu7t8s = '<a draggable="true">'+mon7t8 + ' - ' + lop7t8 + '</a><br>';
        thu7t8.push(thu7t8s);        
    });
    $('#tkbgv tr:eq(7) td:eq(7)').html(thu7t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 9
    var thu2t9 = [];
    lucky2t9.filter(function(number) {
        var mon2t9 = number.tenmon;
        var lop2t9 = number.tenlop;
        var thu2t9s = '<a draggable="true">'+mon2t9 + ' - ' + lop2t9 + '</a><br>';
        thu2t9.push(thu2t9s);        
    });
    $('#tkbgv tr:eq(8) td:eq(2)').html(thu2t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t9 = [];
    lucky3t9.filter(function(number) {
        var mon3t9 = number.tenmon;
        var lop3t9 = number.tenlop;
        var thu3t9s = '<a draggable="true">'+mon3t9 + ' - ' + lop3t9 + '</a><br>';
        thu3t9.push(thu3t9s);        
    });
    $('#tkbgv tr:eq(8) td:eq(3)').html(thu3t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t9 = [];
    lucky4t9.filter(function(number) {
        var mon4t9 = number.tenmon;
        var lop4t9 = number.tenlop;
        var thu4t9s = '<a draggable="true">'+mon4t9 + ' - ' + lop4t9 + '</a><br>';
        thu4t9.push(thu4t9s);        
    });
    $('#tkbgv tr:eq(8) td:eq(4)').html(thu4t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t9 = [];
    lucky5t9.filter(function(number) {
        var mon5t9 = number.tenmon;
        var lop5t9 = number.tenlop;
        var thu5t9s = '<a draggable="true">'+mon5t9 + ' - ' + lop5t9 + '</a><br>';
        thu5t9.push(thu5t9s);        
    });
    $('#tkbgv tr:eq(8) td:eq(5)').html(thu5t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t9 = [];
    lucky6t9.filter(function(number) {
        var mon6t9 = number.tenmon;
        var lop6t9 = number.tenlop;
        var thu6t9s = '<a draggable="true">'+mon6t9 + ' - ' + lop6t9 + '</a><br>';
        thu6t9.push(thu6t9s);        
    });
    $('#tkbgv tr:eq(8) td:eq(6)').html(thu6t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t9 = [];
    lucky7t9.filter(function(number) {
        var mon7t9 = number.tenmon;
        var lop7t9 = number.tenlop;
        var thu7t9s = '<a draggable="true">'+mon7t9 + ' - ' + lop7t9 + '</a><br>';
        thu7t9.push(thu7t9s);        
    });
    $('#tkbgv tr:eq(8) td:eq(7)').html(thu7t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 10
    var thu2t10 = [];
    lucky2t10.filter(function(number) {
        var mon2t10 = number.tenmon;
        var lop2t10 = number.tenlop;
        var thu2t10s = '<a draggable="true">'+mon2t10 + ' - ' + lop2t10 + '</a><br>';
        thu2t10.push(thu2t10s);        
    });
    $('#tkbgv tr:eq(9) td:eq(2)').html(thu2t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t10 = [];
    lucky3t10.filter(function(number) {
        var mon3t10 = number.tenmon;
        var lop3t10 = number.tenlop;
        var thu3t10s = '<a draggable="true">'+mon3t10 + ' - ' + lop3t10 + '</a><br>';
        thu3t10.push(thu3t10s);        
    });
    $('#tkbgv tr:eq(9) td:eq(3)').html(thu3t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t10 = [];
    lucky4t10.filter(function(number) {
        var mon4t10 = number.tenmon;
        var lop4t10 = number.tenlop;
        var thu4t10s = '<a draggable="true">'+mon4t10 + ' - ' + lop4t10 + '</a><br>';
        thu4t10.push(thu4t10s);        
    });
    $('#tkbgv tr:eq(9) td:eq(4)').html(thu4t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t10 = [];
    lucky5t10.filter(function(number) {
        var mon5t10 = number.tenmon;
        var lop5t10 = number.tenlop;
        var thu5t10s = '<a draggable="true">'+mon5t10 + ' - ' + lop5t10 + '</a><br>';
        thu5t10.push(thu5t10s);        
    });
    $('#tkbgv tr:eq(9) td:eq(5)').html(thu5t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t10 = [];
    lucky6t10.filter(function(number) {
        var mon6t10 = number.tenmon;
        var lop6t10 = number.tenlop;
        var thu6t10s = '<a draggable="true">'+mon6t10 + ' - ' + lop6t10 + '</a><br>';
        thu6t10.push(thu6t10s);        
    });
    $('#tkbgv tr:eq(9) td:eq(6)').html(thu6t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t10 = [];
    lucky7t10.filter(function(number) {
        var mon7t10 = number.tenmon;
        var lop7t10 = number.tenlop;
        var thu7t10s = '<a draggable="true">'+mon7t10 + ' - ' + lop7t10 + '</a><br>';
        thu7t10.push(thu7t10s);        
    });
    $('#tkbgv tr:eq(9) td:eq(7)').html(thu7t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');







    var tablegv = $('#example2').DataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        "searching": false,
        "retrieve": true,
        "bStateSave": true,
        "bSort": false,
        drawCallback: function() {
            cells = document.querySelectorAll('#example2 td');
            [].forEach.call(cells, function(cell) {
                cell.addEventListener('dragstart', handleDragStart, false);
                cell.addEventListener('dragenter', handleDragEnter, false)
                cell.addEventListener('dragover', handleDragOver, false);
                cell.addEventListener('dragleave', handleDragLeave, false);
                cell.addEventListener('drop', handleDrop, false);
                cell.addEventListener('dragend', handleDragEnd, false);
            });
        }
    });


    var dragSrc = null;
    var cells = null;

    function handleDragStart(e) {
        this.style.opacity = '0.4';
        dragSrc = this;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.innerHTML);
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    function handleDragEnter(e) {
        this.classList.add('over');
    }

    function handleDragLeave(e) {
        this.classList.remove('over');
    }

    function handleDrop(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }
        if (dragSrc != this) {
            dragSrc.innerHTML = this.innerHTML;
            this.innerHTML = e.dataTransfer.getData('text/html');
            table.cell(dragSrc).invalidate();
            table.cell(this).invalidate().draw(false);
        }
        return false;
    }

    function handleDragEnd(e) {
        this.style.opacity = '1.0';
        [].forEach.call(cells, function(cell) {
            cell.classList.remove('over');
        });
    }

    console.log(tkbtemp);
    return tkbtemp;
}




function thoikhoabieulop(malop, thoikhoabieu) {
    let tkbtemp = [];
    document.getElementById("cardxeptkblop").style.display = "block";
    let index = 0;
    for (let thu = 2; thu < 8; thu++) {
        for (let tiet = 1; tiet < 11; tiet++) {
            // chỗ này sử dụng phương thức gán vào mảng đã có chứ ko push
            if (thoikhoabieu[index].malop == malop) {
                tkbtemp.push(thoikhoabieu[index]);
            }
            index++;
        }
    }
    $('#titletkblop').html('Thời khóa biểu lớp: '+tkbtemp[0].tenlop);

    var datas = tkbtemp;


    //tiet 1
    let lucky2t1 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky3t1 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky4t1 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky5t1 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky6t1 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });
    let lucky7t1 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 1) {
            return number;
        }
    });

    //tiet 2
    let lucky2t2 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky3t2 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky4t2 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky5t2 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky6t2 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });
    let lucky7t2 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 2) {
            return number;
        }
    });


    //tiet 3
    let lucky2t3 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky3t3 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky4t3 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky5t3 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky6t3 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });
    let lucky7t3 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 3) {
            return number;
        }
    });


    //tiet 4
    let lucky2t4 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });

    let lucky3t4 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });

    let lucky4t4 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    let lucky5t4 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    let lucky6t4 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });
    let lucky7t4 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 4) {
            return number;
        }
    });

    //tiet 5
    let lucky2t5 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky3t5 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky4t5 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky5t5 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky6t5 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });
    let lucky7t5 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 0 && number.tiet == 5) {
            return number;
        }
    });


    //tiet 6
    let lucky2t6 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky3t6 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky4t6 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky5t6 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky6t6 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky7t6 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });


    //tiet 7
    let lucky2t7 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 6) {
            return number;
        }
    });
    let lucky3t7 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });
    let lucky4t7 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });
    let lucky5t7 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });
    let lucky6t7 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });
    let lucky7t7 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 7) {
            return number;
        }
    });


    //tiet 8
    let lucky2t8 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky3t8 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky4t8 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky5t8 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky6t8 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });
    let lucky7t8 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 8) {
            return number;
        }
    });


    //tiet 9
    let lucky2t9 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky3t9 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky4t9 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky5t9 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky6t9 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });
    let lucky7t9 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 9) {
            return number;
        }
    });


    //tiet 10
    let lucky2t10 = datas.filter(function(number) {
        if (number.thu == 2 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky3t10 = datas.filter(function(number) {
        if (number.thu == 3 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky4t10 = datas.filter(function(number) {
        if (number.thu == 4 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky5t10 = datas.filter(function(number) {
        if (number.thu == 5 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky6t10 = datas.filter(function(number) {
        if (number.thu == 6 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });
    let lucky7t10 = datas.filter(function(number) {
        if (number.thu == 7 && number.buoi == 1 && number.tiet == 10) {
            return number;
        }
    });



    //t2 tiet 1
    var thu2t1 = [];
    lucky2t1.filter(function(number) {
        var mon2t1 = number.tenmon;
        var gv2t1 = number.hovatengv;
        var thu2t1s = '<a draggable="true">'+mon2t1 + ' - ' + gv2t1 + '</a><br>';
        thu2t1.push(thu2t1s);        
    });
    $('#tkblop tr:eq(0) td:eq(2)').html(thu2t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 1
    var thu3t1 = [];
    lucky3t1.filter(function(number) {
        var mon3t1 = number.tenmon;
        var gv3t1 = number.hovatengv;
        var thu3t1s = '<a draggable="true">'+mon3t1 + ' - ' + gv3t1 + '</a><br>';
        thu3t1.push(thu3t1s);        
    });
    $('#tkblop tr:eq(0) td:eq(3)').html(thu3t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 1
    var thu4t1 = [];
    lucky4t1.filter(function(number) {
        var mon4t1 = number.tenmon;
        var gv4t1 = number.hovatengv;
        var thu4t1s = '<a draggable="true">'+mon4t1 + ' - ' + gv4t1 + '</a><br>';
        thu4t1.push(thu4t1s);        
    });
    $('#tkblop tr:eq(0) td:eq(4)').html(thu4t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 1
    var thu5t1 = [];
    lucky5t1.filter(function(number) {
        var mon5t1 = number.tenmon;
        var gv5t1 = number.hovatengv;
        var thu5t1s = '<a draggable="true">'+mon5t1 + ' - ' + gv5t1 + '</a><br>';
        thu5t1.push(thu5t1s);        
    });
    $('#tkblop tr:eq(0) td:eq(5)').html(thu5t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 1
    var thu6t1 = [];
    lucky6t1.filter(function(number) {
        var mon6t1 = number.tenmon;
        var gv6t1 = number.hovatengv;
        var thu6t1s = '<a draggable="true">'+mon6t1 + ' - ' + gv6t1 + '</a><br>';
        thu6t1.push(thu6t1s);        
    });
    $('#tkblop tr:eq(0) td:eq(6)').html(thu6t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 1
    var thu7t1 = [];
    lucky7t1.filter(function(number) {
        var mon7t1 = number.tenmon;
        var gv7t1 = number.hovatengv;
        var thu7t1s = '<a draggable="true">'+mon7t1 + ' - ' + gv7t1 + '</a><br>';
        thu7t1.push(thu7t1s);        
    });
    $('#tkblop tr:eq(0) td:eq(7)').html(thu7t1).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 2
    var thu2t2 = [];
    lucky2t2.filter(function(number) {
        var mon2t2 = number.tenmon;
        var gv2t2 = number.hovatengv;
        var thu2t2s = '<a draggable="true">'+mon2t2 + ' - ' + gv2t2 + '</a><br>';
        thu2t2.push(thu2t2s);        
    });
    $('#tkblop tr:eq(1) td:eq(2)').html(thu2t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t2 = [];
    lucky3t2.filter(function(number) {
        var mon3t2 = number.tenmon;
        var gv3t2 = number.hovatengv;
        var thu3t2s = '<a draggable="true">'+mon3t2 + ' - ' + gv3t2 + '</a><br>';
        thu3t2.push(thu3t2s);        
    });
    $('#tkblop tr:eq(1) td:eq(3)').html(thu3t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t2 = [];
    lucky4t2.filter(function(number) {
        var mon4t2 = number.tenmon;
        var gv4t2 = number.hovatengv;
        var thu4t2s = '<a draggable="true">'+mon4t2 + ' - ' + gv4t2 + '</a><br>';
        thu4t2.push(thu4t2s);        
    });
    $('#tkblop tr:eq(1) td:eq(4)').html(thu4t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t2 = [];
    lucky5t2.filter(function(number) {
        var mon5t2 = number.tenmon;
        var gv5t2 = number.hovatengv;
        var thu5t2s = '<a draggable="true">'+mon5t2 + ' - ' + gv5t2 + '</a><br>';
        thu5t2.push(thu5t2s);        
    });
    $('#tkblop tr:eq(1) td:eq(5)').html(thu5t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t2 = [];
    lucky6t2.filter(function(number) {
        var mon6t2 = number.tenmon;
        var gv6t2 = number.hovatengv;
        var thu6t2s = '<a draggable="true">'+mon6t2 + ' - ' + gv6t2 + '</a><br>';
        thu6t2.push(thu6t2s);        
    });
    $('#tkblop tr:eq(1) td:eq(6)').html(thu6t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t2 = [];
    lucky7t2.filter(function(number) {
        var mon7t2 = number.tenmon;
        var gv7t2 = number.hovatengv;
        var thu7t2s = '<a draggable="true">'+mon7t2 + ' - ' + gv7t2 + '</a><br>';
        thu7t2.push(thu7t2s);        
    });
    $('#tkblop tr:eq(1) td:eq(7)').html(thu7t2).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 3
    var thu2t3 = [];
    lucky2t3.filter(function(number) {
        var mon2t3 = number.tenmon;
        var gv2t3 = number.hovatengv;
        var thu2t3s = '<a draggable="true">'+mon2t3 + ' - ' + gv2t3 + '</a><br>';
        thu2t3.push(thu2t3s);        
    });
    $('#tkblop tr:eq(2) td:eq(2)').html(thu2t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 3
    var thu3t3 = [];
    lucky3t3.filter(function(number) {
        var mon3t3 = number.tenmon;
        var gv3t3 = number.hovatengv;
        var thu3t3s = '<a draggable="true">'+mon3t3 + ' - ' + gv3t3 + '</a><br>';
        thu3t3.push(thu3t3s);        
    });
    $('#tkblop tr:eq(2) td:eq(3)').html(thu3t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 3
    var thu4t3 = [];
    lucky4t3.filter(function(number) {
        var mon4t3 = number.tenmon;
        var gv4t3 = number.hovatengv;
        var thu4t3s = '<a draggable="true">'+mon4t3 + ' - ' + gv4t3 + '</a><br>';
        thu4t3.push(thu4t3s);        
    });
    $('#tkblop tr:eq(2) td:eq(4)').html(thu4t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 3
    var thu5t3 = [];
    lucky5t3.filter(function(number) {
        var mon5t3 = number.tenmon;
        var gv5t3 = number.hovatengv;
        var thu5t3s = '<a draggable="true">'+mon5t3 + ' - ' + gv5t3 + '</a><br>';
        thu5t3.push(thu5t3s);        
    });
    $('#tkblop tr:eq(2) td:eq(5)').html(thu5t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 3
    var thu6t3 = [];
    lucky6t3.filter(function(number) {
        var mon6t3 = number.tenmon;
        var gv6t3 = number.hovatengv;
        var thu6t3s = '<a draggable="true">'+mon6t3 + ' - ' + gv6t3 + '</a><br>';
        thu6t3.push(thu6t3s);        
    });
    $('#tkblop tr:eq(2) td:eq(6)').html(thu6t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 3
    var thu7t3 = [];
    lucky7t3.filter(function(number) {
        var mon7t3 = number.tenmon;
        var gv7t3 = number.hovatengv;
        var thu7t3s = '<a draggable="true">'+mon7t3 + ' - ' + gv7t3 + '</a><br>';
        thu7t3.push(thu7t3s);        
    });
    $('#tkblop tr:eq(2) td:eq(7)').html(thu7t3).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 4
    var thu2t4 = [];
    lucky2t4.filter(function(number) {
        var mon2t4 = number.tenmon;
        var gv2t4 = number.hovatengv;
        var thu2t4s = '<a draggable="true">'+mon2t4 + ' - ' + gv2t4 + '</a><br>';
        thu2t4.push(thu2t4s);        
    });
    $('#tkblop tr:eq(3) td:eq(2)').html(thu2t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 4
    var thu3t4 = [];
    lucky3t4.filter(function(number) {
        var mon3t4 = number.tenmon;
        var gv3t4 = number.hovatengv;
        var thu3t4s = '<a draggable="true">'+mon3t4 + ' - ' + gv3t4 + '</a><br>';
        thu3t4.push(thu3t4s);        
    });
    $('#tkblop tr:eq(3) td:eq(3)').html(thu3t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 4
    var thu4t4 = [];
    lucky4t4.filter(function(number) {
        var mon4t4 = number.tenmon;
        var gv4t4 = number.hovatengv;
        var thu4t4s = '<a draggable="true">'+mon4t4 + ' - ' + gv4t4 + '</a><br>';
        thu4t4.push(thu4t4s);        
    });
    $('#tkblop tr:eq(3) td:eq(4)').html(thu4t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 4
    var thu5t4 = [];
    lucky5t4.filter(function(number) {
        var mon5t4 = number.tenmon;
        var gv5t4 = number.hovatengv;
        var thu5t4s = '<a draggable="true">'+mon5t4 + ' - ' + gv5t4 + '</a><br>';
        thu5t4.push(thu5t4s);        
    });
    $('#tkblop tr:eq(3) td:eq(5)').html(thu5t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 4
    var thu6t4 = [];
    lucky6t4.filter(function(number) {
        var mon6t4 = number.tenmon;
        var gv6t4 = number.hovatengv;
        var thu6t4s = '<a draggable="true">'+mon6t4 + ' - ' + gv6t4 + '</a><br>';
        thu6t4.push(thu6t4s);        
    });
    $('#tkblop tr:eq(3) td:eq(6)').html(thu6t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 4
    var thu7t4 = [];
    lucky7t4.filter(function(number) {
        var mon7t4 = number.tenmon;
        var gv7t4 = number.hovatengv;
        var thu7t4s = '<a draggable="true">'+mon7t4 + ' - ' + gv7t4 + '</a><br>';
        thu7t4.push(thu7t4s);        
    });
    $('#tkblop tr:eq(3) td:eq(7)').html(thu7t4).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 5
    var thu2t5 = [];
    lucky2t5.filter(function(number) {
        var mon2t5 = number.tenmon;
        var gv2t5 = number.hovatengv;
        var thu2t5s = '<a draggable="true">'+mon2t5 + ' - ' + gv2t5 + '</a><br>';
        thu2t5.push(thu2t5s);        
    });
    $('#tkblop tr:eq(4) td:eq(2)').html(thu2t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 5
    var thu3t5 = [];
    lucky3t5.filter(function(number) {
        var mon3t5 = number.tenmon;
        var gv3t5 = number.hovatengv;
        var thu3t5s = '<a draggable="true">'+mon3t5 + ' - ' + gv3t5 + '</a><br>';
        thu3t5.push(thu3t5s);        
    });
    $('#tkblop tr:eq(4) td:eq(3)').html(thu3t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 5
    var thu4t5 = [];
    lucky4t5.filter(function(number) {
        var mon4t5 = number.tenmon;
        var gv4t5 = number.hovatengv;
        var thu4t5s = '<a draggable="true">'+mon4t5 + ' - ' + gv4t5 + '</a><br>';
        thu4t5.push(thu4t5s);        
    });
    $('#tkblop tr:eq(4) td:eq(4)').html(thu4t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 5
    var thu5t5 = [];
    lucky5t5.filter(function(number) {
        var mon5t5 = number.tenmon;
        var gv5t5 = number.hovatengv;
        var thu5t5s = '<a draggable="true">'+mon5t5 + ' - ' + gv5t5 + '</a><br>';
        thu5t5.push(thu5t5s);        
    });
    $('#tkblop tr:eq(4) td:eq(5)').html(thu5t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 5
    var thu6t5 = [];
    lucky6t5.filter(function(number) {
        var mon6t5 = number.tenmon;
        var gv6t5 = number.hovatengv;
        var thu6t5s = '<a draggable="true">'+mon6t5 + ' - ' + gv6t5 + '</a><br>';
        thu6t5.push(thu6t5s);        
    });
    $('#tkblop tr:eq(4) td:eq(6)').html(thu6t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 5
    var thu7t5 = [];
    lucky7t5.filter(function(number) {
        var mon7t5 = number.tenmon;
        var gv7t5 = number.hovatengv;
        var thu7t5s = '<a draggable="true">'+mon7t5 + ' - ' + gv7t5 + '</a><br>';
        thu7t5.push(thu7t5s);        
    });
    $('#tkblop tr:eq(4) td:eq(7)').html(thu7t5).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 6
    var thu2t6 = [];
    lucky2t6.filter(function(number) {
        var mon2t6 = number.tenmon;
        var gv2t6 = number.hovatengv;
        var thu2t6s = '<a draggable="true">'+mon2t6 + ' - ' + gv2t6 + '</a><br>';
        thu2t6.push(thu2t6s);        
    });
    $('#tkblop tr:eq(5) td:eq(2)').html(thu2t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t6 = [];
    lucky3t6.filter(function(number) {
        var mon3t6 = number.tenmon;
        var gv3t6 = number.hovatengv;
        var thu3t6s = '<a draggable="true">'+mon3t6 + ' - ' + gv3t6 + '</a><br>';
        thu3t6.push(thu3t6s);        
    });
    $('#tkblop tr:eq(5) td:eq(3)').html(thu3t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t6 = [];
    lucky4t6.filter(function(number) {
        var mon4t6 = number.tenmon;
        var gv4t6 = number.hovatengv;
        var thu4t6s = '<a draggable="true">'+mon4t6 + ' - ' + gv4t6 + '</a><br>';
        thu4t6.push(thu4t6s);        
    });
    $('#tkblop tr:eq(5) td:eq(4)').html(thu4t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t6 = [];
    lucky5t6.filter(function(number) {
        var mon5t6 = number.tenmon;
        var gv5t6 = number.hovatengv;
        var thu5t6s = '<a draggable="true">'+mon5t6 + ' - ' + gv5t6 + '</a><br>';
        thu5t6.push(thu5t6s);        
    });
    $('#tkblop tr:eq(5) td:eq(5)').html(thu5t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t6 = [];
    lucky6t6.filter(function(number) {
        var mon6t6 = number.tenmon;
        var gv6t6 = number.hovatengv;
        var thu6t6s = '<a draggable="true">'+mon6t6 + ' - ' + gv6t6 + '</a><br>';
        thu6t6.push(thu6t6s);        
    });
    $('#tkblop tr:eq(5) td:eq(6)').html(thu6t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t6 = [];
    lucky7t6.filter(function(number) {
        var mon7t6 = number.tenmon;
        var gv7t6 = number.hovatengv;
        var thu7t6s = '<a draggable="true">'+mon7t6 + ' - ' + gv7t6 + '</a><br>';
        thu7t6.push(thu7t6s);        
    });
    $('#tkblop tr:eq(5) td:eq(7)').html(thu7t6).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 7
    var thu2t7 = [];
    lucky2t7.filter(function(number) {
        var mon2t7 = number.tenmon;
        var gv2t7 = number.hovatengv;
        var thu2t7s = '<a draggable="true">'+mon2t7 + ' - ' + gv2t7 + '</a><br>';
        thu2t7.push(thu2t7s);        
    });
    $('#tkblop tr:eq(6) td:eq(2)').html(thu2t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t7 = [];
    lucky3t7.filter(function(number) {
        var mon3t7 = number.tenmon;
        var gv3t7 = number.hovatengv;
        var thu3t7s = '<a draggable="true">'+mon3t7 + ' - ' + gv3t7 + '</a><br>';
        thu3t7.push(thu3t7s);        
    });
    $('#tkblop tr:eq(6) td:eq(3)').html(thu3t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t7 = [];
    lucky4t7.filter(function(number) {
        var mon4t7 = number.tenmon;
        var gv4t7 = number.hovatengv;
        var thu4t7s = '<a draggable="true">'+mon4t7 + ' - ' + gv4t7 + '</a><br>';
        thu4t7.push(thu4t7s);        
    });
    $('#tkblop tr:eq(6) td:eq(4)').html(thu4t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t7 = [];
    lucky5t7.filter(function(number) {
        var mon5t7 = number.tenmon;
        var gv5t7 = number.hovatengv;
        var thu5t7s = '<a draggable="true">'+mon5t7 + ' - ' + gv5t7 + '</a><br>';
        thu5t7.push(thu5t7s);        
    });
    $('#tkblop tr:eq(6) td:eq(5)').html(thu5t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t7 = [];
    lucky6t7.filter(function(number) {
        var mon6t7 = number.tenmon;
        var gv6t7 = number.hovatengv;
        var thu6t7s = '<a draggable="true">'+mon6t7 + ' - ' + gv6t7 + '</a><br>';
        thu6t7.push(thu6t7s);        
    });
    $('#tkblop tr:eq(6) td:eq(6)').html(thu6t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t7 = [];
    lucky7t7.filter(function(number) {
        var mon7t7 = number.tenmon;
        var gv7t7 = number.hovatengv;
        var thu7t7s = '<a draggable="true">'+mon7t7 + ' - ' + gv7t7 + '</a><br>';
        thu7t7.push(thu7t7s);        
    });
    $('#tkblop tr:eq(6) td:eq(7)').html(thu7t7).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 8
    var thu2t8 = [];
    lucky2t8.filter(function(number) {
        var mon2t8 = number.tenmon;
        var gv2t8 = number.hovatengv;
        var thu2t8s = '<a draggable="true">'+mon2t8 + ' - ' + gv2t8 + '</a><br>';
        thu2t8.push(thu2t8s);        
    });
    $('#tkblop tr:eq(7) td:eq(2)').html(thu2t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t8 = [];
    lucky3t8.filter(function(number) {
        var mon3t8 = number.tenmon;
        var gv3t8 = number.hovatengv;
        var thu3t8s = '<a draggable="true">'+mon3t8 + ' - ' + gv3t8 + '</a><br>';
        thu3t8.push(thu3t8s);        
    });
    $('#tkblop tr:eq(7) td:eq(3)').html(thu3t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t8 = [];
    lucky4t8.filter(function(number) {
        var mon4t8 = number.tenmon;
        var gv4t8 = number.hovatengv;
        var thu4t8s = '<a draggable="true">'+mon4t8 + ' - ' + gv4t8 + '</a><br>';
        thu4t8.push(thu4t8s);        
    });
    $('#tkblop tr:eq(7) td:eq(4)').html(thu4t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t8 = [];
    lucky5t8.filter(function(number) {
        var mon5t8 = number.tenmon;
        var gv5t8 = number.hovatengv;
        var thu5t8s = '<a draggable="true">'+mon5t8 + ' - ' + gv5t8 + '</a><br>';
        thu5t8.push(thu5t8s);        
    });
    $('#tkblop tr:eq(7) td:eq(5)').html(thu5t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t8 = [];
    lucky6t8.filter(function(number) {
        var mon6t8 = number.tenmon;
        var gv6t8 = number.hovatengv;
        var thu6t8s = '<a draggable="true">'+mon6t8 + ' - ' + gv6t8 + '</a><br>';
        thu6t8.push(thu6t8s);        
    });
    $('#tkblop tr:eq(7) td:eq(6)').html(thu6t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t8 = [];
    lucky7t8.filter(function(number) {
        var mon7t8 = number.tenmon;
        var gv7t8 = number.hovatengv;
        var thu7t8s = '<a draggable="true">'+mon7t8 + ' - ' + gv7t8 + '</a><br>';
        thu7t8.push(thu7t8s);        
    });
    $('#tkblop tr:eq(7) td:eq(7)').html(thu7t8).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 9
    var thu2t9 = [];
    lucky2t9.filter(function(number) {
        var mon2t9 = number.tenmon;
        var gv2t9 = number.hovatengv;
        var thu2t9s = '<a draggable="true">'+mon2t9 + ' - ' + gv2t9 + '</a><br>';
        thu2t9.push(thu2t9s);        
    });
    $('#tkblop tr:eq(8) td:eq(2)').html(thu2t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t9 = [];
    lucky3t9.filter(function(number) {
        var mon3t9 = number.tenmon;
        var gv3t9 = number.hovatengv;
        var thu3t9s = '<a draggable="true">'+mon3t9 + ' - ' + gv3t9 + '</a><br>';
        thu3t9.push(thu3t9s);        
    });
    $('#tkblop tr:eq(8) td:eq(3)').html(thu3t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t9 = [];
    lucky4t9.filter(function(number) {
        var mon4t9 = number.tenmon;
        var gv4t9 = number.hovatengv;
        var thu4t9s = '<a draggable="true">'+mon4t9 + ' - ' + gv4t9 + '</a><br>';
        thu4t9.push(thu4t9s);        
    });
    $('#tkblop tr:eq(8) td:eq(4)').html(thu4t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t9 = [];
    lucky5t9.filter(function(number) {
        var mon5t9 = number.tenmon;
        var gv5t9 = number.hovatengv;
        var thu5t9s = '<a draggable="true">'+mon5t9 + ' - ' + gv5t9 + '</a><br>';
        thu5t9.push(thu5t9s);        
    });
    $('#tkblop tr:eq(8) td:eq(5)').html(thu5t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t9 = [];
    lucky6t9.filter(function(number) {
        var mon6t9 = number.tenmon;
        var gv6t9 = number.hovatengv;
        var thu6t9s = '<a draggable="true">'+mon6t9 + ' - ' + gv6t9 + '</a><br>';
        thu6t9.push(thu6t9s);        
    });
    $('#tkblop tr:eq(8) td:eq(6)').html(thu6t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t9 = [];
    lucky7t9.filter(function(number) {
        var mon7t9 = number.tenmon;
        var gv7t9 = number.hovatengv;
        var thu7t9s = '<a draggable="true">'+mon7t9 + ' - ' + gv7t9 + '</a><br>';
        thu7t9.push(thu7t9s);        
    });
    $('#tkblop tr:eq(8) td:eq(7)').html(thu7t9).attr('style','border: 1px solid #ddd;white-space: nowrap;');



    //t2 tiet 10
    var thu2t10 = [];
    lucky2t10.filter(function(number) {
        var mon2t10 = number.tenmon;
        var gv2t10 = number.hovatengv;
        var thu2t10s = '<a draggable="true">'+mon2t10 + ' - ' + gv2t10 + '</a><br>';
        thu2t10.push(thu2t10s);        
    });
    $('#tkblop tr:eq(9) td:eq(2)').html(thu2t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t3 tiet 2
    var thu3t10 = [];
    lucky3t10.filter(function(number) {
        var mon3t10 = number.tenmon;
        var gv3t10 = number.hovatengv;
        var thu3t10s = '<a draggable="true">'+mon3t10 + ' - ' + gv3t10 + '</a><br>';
        thu3t10.push(thu3t10s);        
    });
    $('#tkblop tr:eq(9) td:eq(3)').html(thu3t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t4 tiet 2
    var thu4t10 = [];
    lucky4t10.filter(function(number) {
        var mon4t10 = number.tenmon;
        var gv4t10 = number.hovatengv;
        var thu4t10s = '<a draggable="true">'+mon4t10 + ' - ' + gv4t10 + '</a><br>';
        thu4t10.push(thu4t10s);        
    });
    $('#tkblop tr:eq(9) td:eq(4)').html(thu4t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t5 tiet 2
    var thu5t10 = [];
    lucky5t10.filter(function(number) {
        var mon5t10 = number.tenmon;
        var gv5t10 = number.hovatengv;
        var thu5t10s = '<a draggable="true">'+mon5t10 + ' - ' + gv5t10 + '</a><br>';
        thu5t10.push(thu5t10s);        
    });
    $('#tkblop tr:eq(9) td:eq(5)').html(thu5t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t6 tiet 2
    var thu6t10 = [];
    lucky6t10.filter(function(number) {
        var mon6t10 = number.tenmon;
        var gv6t10 = number.hovatengv;
        var thu6t10s = '<a draggable="true">'+mon6t10 + ' - ' + gv6t10 + '</a><br>';
        thu6t10.push(thu6t10s);        
    });
    $('#tkblop tr:eq(9) td:eq(6)').html(thu6t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');
    //t7 tiet 2
    var thu7t10 = [];
    lucky7t10.filter(function(number) {
        var mon7t10 = number.tenmon;
        var gv7t10 = number.hovatengv;
        var thu7t10s = '<a draggable="true">'+mon7t10 + ' - ' + gv7t10 + '</a><br>';
        thu7t10.push(thu7t10s);        
    });
    $('#tkblop tr:eq(9) td:eq(7)').html(thu7t10).attr('style','border: 1px solid #ddd;white-space: nowrap;');




    var tablegv = $('#example3').DataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        "searching": false,
        "retrieve": true,
        "bStateSave": true,
        "bSort": false,


        drawCallback: function() {
            // Apply HTML5 drag and drop listeners to all cells
            cells = document.querySelectorAll('#example3 td');
            [].forEach.call(cells, function(cell) {
                cell.addEventListener('dragstart', handleDragStart, false);
                cell.addEventListener('dragenter', handleDragEnter, false)
                cell.addEventListener('dragover', handleDragOver, false);
                cell.addEventListener('dragleave', handleDragLeave, false);
                cell.addEventListener('drop', handleDrop, false);
                cell.addEventListener('dragend', handleDragEnd, false);
            });
        }
    });




    var dragSrc = null; //Globally track source cell
    var cells = null; // All cells in table



    function handleDragStart(e) {
        this.style.opacity = '0.4'; // this / e.target is the source node.
        dragSrc = this; // Keep track of source cell

        // Allow moves
        e.dataTransfer.effectAllowed = 'move';

        // Get the cell data and store in the transfer data object
        e.dataTransfer.setData('text/html', this.innerHTML);
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault(); // Necessary. Allows us to drop.
        }

        // Allow moves
        e.dataTransfer.dropEffect = 'move'; // See the section on the DataTransfer object.

        return false;
    }

    function handleDragEnter(e) {
        // this / e.target is the current hover target.

        // Apply drop zone visual
        this.classList.add('over');
    }

    function handleDragLeave(e) {
        // this / e.target is previous target element.

        // Remove drop zone visual
        this.classList.remove('over');
    }

    function handleDrop(e) {
        // this / e.target is current target element.

        if (e.stopPropagation) {
            e.stopPropagation(); // stops the browser from redirecting.
        }



        // Don't do anything if dropping the same column we're dragging.
        if (dragSrc != this) {
            // Set the source column's HTML to the HTML of the column we dropped on.
            dragSrc.innerHTML = this.innerHTML;

            // Set the distination cell to the transfer data from the source
            this.innerHTML = e.dataTransfer.getData('text/html');

            // Invalidate the src cell and dst cell to have DT update its cache then draw
            table.cell(dragSrc).invalidate();
            table.cell(this).invalidate().draw(false);
        }




        return false;
    }

    function handleDragEnd(e) {
        // this/e.target is the source node.
        this.style.opacity = '1.0';
        [].forEach.call(cells, function(cell) {
            // Make sure to remove drop zone visual class
            cell.classList.remove('over');
        });
    }

    console.log(tkbtemp);
    return tkbtemp;


}


function tieptucXepTKB() {
    setRangbuoc();
    console.log(arrGiaovien);
    console.log(arrLophoc);
    console.log(arrPhonghoc);
    console.log(arrrangbuoc);
}




var dragSrc = null; //Globally track source cell
var cells = null; // All cells in table



function handleDragStart(e) {
    this.style.opacity = '0.4'; // this / e.target is the source node.
    dragSrc = this; // Keep track of source cell

    // Allow moves
    e.dataTransfer.effectAllowed = 'move';

    // Get the cell data and store in the transfer data object
    e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault(); // Necessary. Allows us to drop.
    }

    // Allow moves
    e.dataTransfer.dropEffect = 'move'; // See the section on the DataTransfer object.

    return false;
}

function handleDragEnter(e) {
    // this / e.target is the current hover target.

    // Apply drop zone visual
    this.classList.add('over');
}

function handleDragLeave(e) {
    // this / e.target is previous target element.

    // Remove drop zone visual
    this.classList.remove('over');
}

function handleDrop(e) {
    // this / e.target is current target element.

    if (e.stopPropagation) {
        e.stopPropagation(); // stops the browser from redirecting.
    }



    // Don't do anything if dropping the same column we're dragging.
    if (dragSrc != this) {
        // Set the source column's HTML to the HTML of the column we dropped on.
        dragSrc.innerHTML = this.innerHTML;

        // Set the distination cell to the transfer data from the source
        this.innerHTML = e.dataTransfer.getData('text/html');

        // Invalidate the src cell and dst cell to have DT update its cache then draw
        table.cell(dragSrc).invalidate();
        table.cell(this).invalidate().draw(false);
    }




    return false;
}

function handleDragEnd(e) {
    // this/e.target is the source node.
    this.style.opacity = '1.0';
    [].forEach.call(cells, function(cell) {
        // Make sure to remove drop zone visual class
        cell.classList.remove('over');
    });
}
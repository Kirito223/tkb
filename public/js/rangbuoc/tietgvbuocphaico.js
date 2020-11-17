var tbodySubjects, tbodyClass, tbodyConstraints;
var listClassRoom;
var listSubject;
var arrConstrainstData = [];

function reloadgvthamgiagiangday() {
    chongvthamgiagiangday();
    loaddatadanhsachgvthamgiagiangday();
    var dataGrid = $("#girdtietgiaovienbuocphaico").dxDataGrid("instance");
    dataGrid.clearSelection();
    dataGrid.refresh();
}

async function loaddatadanhsachgvthamgiagiangday() {
    tbodySubjects = document.getElementById("tbodySubjects");
    tbodyClass = document.getElementById("tbodyClass");
    tbodyConstraints = document.getElementById("tbodyConstraints");
    listClassRoom = await loadListClassroom();
    listSubject = await loadListSubject();
    var data = axios.get("gettietgvbuocphaico").then(function(response) {
        var data1 = response.data;
        // console.log(data1);
        var data2 = [];
        var lucky1 = data1.filter(function(items) {
            if (items.monhoc != "") {
                data2.push({
                    id: items.id,
                    ten: items.hovaten,
                    bidanh: items.bidanh,
                    thutuhienthi: items.thutuhienthi,
                    monhoc: items.monhoc,
                    rangbuoctietgvbuocphaico: items.rangbuoctietgvbuocphaico
                });
            }
        });
        var data3 = [];
        var lucky2 = data2.filter(function(items1) {
            var magiaovien = items1.id;
            var data4 = [];
            data3.push({
                id: items1.id,
                ten: items1.ten,
                bidanh: items1.bidanh,
                thutuhienthi: items1.thutuhienthi,
                monhoc: data4,
                rangbuoctietgvbuocphaico: items1.rangbuoctietgvbuocphaico
            });
            var datamh = items1.monhoc;
            var lucky3 = datamh.filter(function(items2) {
                if (magiaovien == items2.magiaovien) {
                    var malop = items2.malop;
                    var sotiet = items2.sotiet;
                    var mamonhoc = items2.mamonhoc;
                    var datalop = items2.danhsachlophoc;
                    var data5 = [];
                    data4.push({
                        id: items2.id,
                        malop: items2.malop,
                        magiaovien: items2.magiaovien,
                        tenmonhoc: items2.tenmonhoc,
                        lop: data5
                    });
                    if (malop == datalop.id) {
                        data5.push({
                            id: datalop.id,
                            mamonhoc: mamonhoc,
                            tenlop: datalop.tenlop,
                            sotiet: sotiet
                        });
                    }
                }
            });
        });

        var datas = data3.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, { stt: stt.toString() });
            return datas;
        });
        chongvthamgiagiangday(datas);
    });
}

function chongvthamgiagiangday(datas) {
    // console.log(datas);

    $("#girdtietgiaovienbuocphaico").dxDataGrid({
        dataSource: datas,
        showBorders: true,
        paging: {
            pageSize: 10
        },
        /* xap xep */
        sorting: {
            mode: "multiple"
        },

        searchPanel: {
            visible: true,
            width: 240,
            placeholder: "Tìm kiếm..."
        },
        pager: {
            showPageSizeSelector: true,
            allowedPageSizes: [5, 10, 20],
            showInfo: true
        },

        /* co dan cot */
        allowColumnResizing: true,
        columnResizingMode: "widget",
        onEditorPreparing: function(e) {
            if (e.dataField == "stt" && e.parentType == "dataRow") {
                e.editorOptions.readOnly = true;
            }
            if (e.dataField == "ten" && e.parentType == "dataRow") {
                e.editorOptions.readOnly = true;
            }
            if (e.dataField == "bidanh" && e.parentType == "dataRow") {
                e.editorOptions.readOnly = true;
            }
            if (e.dataField == "monhoc" && e.parentType == "dataRow") {
                e.editorOptions.readOnly = true;
            }
        },
        columns: [
            {
                caption: "STT",
                dataField: "stt",
                width: 50
            },
            {
                caption: "Tên",
                dataField: "ten"
            },
            {
                caption: "Bí danh(Tên hiển thị trên TKB)",
                dataField: "bidanh"
            },
            {
                caption: "Đăng ký tiết buộc phải có",
                // dataField: "bidanh",
                cellTemplate: function(container, options) {
                    var datarbtgvbpc = options.data.rangbuoctietgvbuocphaico;
                    var temp = datarbtgvbpc
                        .map(function(value) {
                            var buoi;
                            if (value.buoi == 0) {
                                buoi = "Sáng";
                            } else {
                                buoi = "Chiều";
                            }
                            return (
                                "Tiết " +
                                value.tiet +
                                " (Thứ " +
                                value.thu +
                                " - " +
                                buoi +
                                "; Mức: " +
                                value.mamucrangbuoc +
                                ")"
                            );
                        })
                        .join(", ");
                    // console.log(temp);
                    $("<div>")
                        .attr("id", "id")
                        // .attr("hidden","hidden")
                        .appendTo(container)
                        .text(temp)
                        .css("white-space", "normal")
                        .css("overflow-wrap", "break-word");

                    container.addClass("right");
                    $("<div>")
                        .dxButton({
                            stylingMode: "outlined",
                            text: "Chọn tiết",
                            type: "default",
                            width: 120,
                            onClick: function(e) {
                                dangkytietbuocphaico(
                                    options.data.id,
                                    options.data.rangbuoctietgvbuocphaico
                                );
                                $("#modaldangkytietbuocphaicogv").modal("show");
                            }
                        })
                        .appendTo(container);
                }
            },
            {
                caption: "Hiển thị phân công CM",
                dataField: "monhoc",
                cellTemplate: function(element, info) {
                    var item = info.value;
                    var groups = {};
                    for (var i = 0; i < item.length; i++) {
                        // console.log(tenmonhoc);
                        var tenmonhoc = item[i].tenmonhoc;
                        if (!groups[tenmonhoc]) {
                            groups[tenmonhoc] = [];
                        }
                        groups[tenmonhoc].push(item[i].lop);
                    }
                    var data_new = [];
                    for (var tenmonhoc in groups) {
                        // console.log(idmonhoc);
                        data_new.push({
                            tenmonhoc: tenmonhoc,
                            lop: groups[tenmonhoc]
                        });
                    }
                    // console.log(data_new);
                    var temp = data_new
                        .map(function(value) {
                            var item1 = value.lop;
                            // console.log(item1);
                            var temp1 = item1
                                .map(function(value1) {
                                    // console.log(value1[0].sotiet);
                                    return (
                                        value1[0].tenlop +
                                        ": " +
                                        value1[0].sotiet
                                    );
                                })
                                .join(", ");
                            // console.log(temp1);
                            return value.tenmonhoc + " (" + temp1 + ")";
                        })
                        .join(", ");
                    // console.log(temp);
                    $("<div>")
                        .attr("id", "noidungpccmid")
                        // .attr("hidden","hidden")
                        .appendTo(element)
                        .text(temp)
                        .css("white-space", "normal")
                        .css("overflow-wrap", "break-word");
                    // return temp;
                }
            }
        ],
        onCellClick: function(e) {
            var data = e.data;
            $("#idgv").val(data.id);
            $("#idbidanhgv").text(data.bidanh);
        }
    });
}

async function loadListClassroom() {
    let result = await axios.get("getdanhsachlophoc").then(res => {
        return res.data;
    });
    return result;
}
async function loadListSubject() {
    let result = await axios.get("getdanhsachmonhoc").then(res => {
        return res.data;
    });
    return result;
}

async function loadListAssginmentOfTeacher(idTeacher) {
    let result = await axios
        .get(`/api/phanconggiaovien/listAssignment/${idTeacher}`)
        .then(res => {
            return res.data.data;
        });
    return result;
}

async function dangkytietbuocphaico(id, constrainstdata) {
    document.getElementById("idgv").value = id;
    var iddatarbtgvbpc = id;

    var arrConstrainst = await loadListAssginmentOfTeacher(iddatarbtgvbpc);
    let arrClass = [];
    let arrSubject = [];
    listClassRoom.forEach(item => {
        let index = arrConstrainst.findIndex(x => (x.malop = item.id));
        if (index > -1) {
            arrClass.push(item);
        }
    });

    listSubject.forEach(item => {
        let indexSubject = arrConstrainst.findIndex(y => y.mamonhoc == item.id);
        if (indexSubject > -1) {
            arrSubject.push(item);
        }
    });

    tbodyClass.innerHTML = "";

    // disabled selectbox
    for (let session = 1; session < 6; session++) {
        for (let day = 2; day < 8; day++) {
            let selectMorning = document.querySelector(
                `#select-session-${session}-${day}th`
            );
            selectMorning.disabled = true;

            let selectAfternoon = document.querySelector(
                `#select-session-pm-${session}-${day}th`
            );
            selectAfternoon.disabled = true;
        }
    }

    arrClass.forEach(item => {
        let tr = document.createElement("tr");
        let checkbox = document.createElement("input");
        checkbox.setAttribute("type", "checkbox");
        checkbox.setAttribute("data-class", item.id);
        checkbox.setAttribute("class", "chkClass");
        let td = document.createElement("td");
        td.setAttribute(
            "style",
            "display: flex; justify-content: space-between;"
        );

        let span = document.createElement("span");
        span.appendChild(checkbox);
        let p = document.createElement("span");
        p.textContent = item.tenlop;

        let chkViewClass = document.createElement("input");
        chkViewClass.setAttribute("type", "checkbox");
        chkViewClass.setAttribute("data-class", item.id);
        chkViewClass.setAttribute("class", "chkViewClass");

        chkViewClass.onclick = function() {
            let chkClass = document.querySelector(
                `.chkClass[data-class="${item.id}"]`
            );
            let oldChkClass = document.getElementsByClassName(".chkClass");
            for (const chkold of oldChkClass) {
                chkold.classList.remove("view");
            }
            chkClass.classList.add("view");
            chkClass.click();
            let oldChk = document.getElementsByClassName("chkViewClass");
            for (const chk of oldChk) {
                chk.checked = false;
            }
            chkViewClass.checked = true;
        };

        span.appendChild(p);
        td.appendChild(span);
        td.appendChild(chkViewClass);
        tr.appendChild(td);
        // set event
        checkbox.onclick = function() {
            if (checkbox.classList.contains("selected")) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
            for (let session = 1; session < 6; session++) {
                for (let day = 2; day < 8; day++) {
                    // set morning
                    let chkMorning = document.getElementById(
                        `session-${session}-${day}th`
                    );
                    chkMorning.checked = false;

                    chkMorning.setAttribute("data-class", item.id);
                    let selectMorning = document.getElementById(
                        `select-session-${session}-${day}th`
                    );

                    selectMorning.setAttribute("data-class", item.id);

                    // set afternoon
                    let chkAfternoon = document.getElementById(
                        `session-pm-${session}-${day}th`
                    );
                    chkAfternoon.checked = false;
                    chkAfternoon.setAttribute("data-class", item.id);
                    let selectAfternoon = document.getElementById(
                        `select-session-pm-${session}-${day}th`
                    );

                    selectAfternoon.setAttribute("data-class", item.id);
                }
            }

            // add data to arrConstainst
            if (checkbox.checked) {
                let find = arrConstrainstData.findIndex(
                    x => x.class == item.id
                );
                if (find == -1) {
                    arrConstrainstData.push({
                        class: item.id,
                        constrainst: []
                    });
                }
            } else {
                let find = arrConstrainstData.findIndex(
                    x => x.class == item.id
                );
                if (find > -1) {
                    arrConstrainstData.splice(find, 1);
                }
            }
        };

        tbodyClass.appendChild(tr);
    });

    tbodySubjects.innerHTML = "";

    arrSubject.forEach(item => {
        let tr = document.createElement("tr");
        let checkbox = document.createElement("input");
        checkbox.setAttribute("type", "checkbox");
        checkbox.setAttribute("data-subject", item.id);
        checkbox.setAttribute("class", "chk-subject");
        let td = document.createElement("td");
        td.setAttribute(
            "style",
            "display: flex; justify-content: space-between;"
        );
        let span = document.createElement("span");
        span.appendChild(checkbox);
        let p = document.createElement("span");
        p.textContent = item.tenmonhoc;

        let chkViewSubject = document.createElement("input");
        chkViewSubject.setAttribute("type", "checkbox");
        chkViewSubject.setAttribute("data-subject", item.id);
        chkViewSubject.setAttribute("class", "chkViewSubject");

        chkViewSubject.onclick = function() {
            let chkSubject = document.querySelector(
                `.chk-subject[data-subject="${item.id}"]`
            );
            chkSubject.classList.add("selected");
            chkSubject.click();
            let oldChk = document.getElementsByClassName("chkViewSubject");
            for (const chk of oldChk) {
                chk.checked = false;
            }
            chkViewSubject.checked = true;

            let checkClass = document.querySelector(".chkViewClass:checked");
            if (checkClass == undefined) {
                Swal.fire(
                    "Vui lòng chọn lớp muốn xem",
                    "Chọn lớp muốn xem",
                    "warning"
                );
                chkViewSubject.checked = false;
            } else {
                // Show phan cong
                let indexClass = arrConstrainstData.find(
                    x => x.class == checkClass.dataset.class
                );
                indexClass.constrainst.forEach(item => {
                    if (item.part == 0) {
                        let chkMorning = document.getElementById(
                            `session-${item.session}-${item.day}th`
                        );
                        chkMorning.checked = true;
                        let selectMorning = document.getElementById(
                            `select-session-${item.session}-${item.day}th`
                        );
                        selectMorning.value = item.level;
                        let selectMornings = document.querySelector(
                            `#select-session-${item.session}-${item.day}th`
                        );
                        selectMornings.disabled = false;
                    } else {
                        let chkAfternoon = document.getElementById(
                            `session-pm-${item.session}-${item.day}th`
                        );
                        chkAfternoon.checked = true;
                        let selectAfternoon = document.getElementById(
                            `select-session-pm-${item.session}-${item.day}th`
                        );
                        selectAfternoon.value = item.level;
                        let selectAfternoons = document.querySelector(
                            `#select-session-pm-${item.session}-${item.day}th`
                        );
                        selectAfternoons.disabled = false;
                    }
                });
            }
        };
        span.appendChild(p);
        td.appendChild(span);
        td.appendChild(chkViewSubject);
        tr.appendChild(td);

        // set event
        checkbox.onclick = function() {
            if (checkbox.classList.contains("selected")) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
            for (let session = 1; session < 6; session++) {
                for (let day = 2; day < 8; day++) {
                    // set morning
                    let chkMorning = document.getElementById(
                        `session-${session}-${day}th`
                    );
                    chkMorning.checked = false;
                    chkMorning.setAttribute("data-subject", item.id);
                    chkMorning.setAttribute("data-session", session);
                    chkMorning.setAttribute("data-day", day);
                    // set event
                    chkMorning.onclick = function() {
                        if (chkMorning.checked) {
                            let selectMorning = document.querySelector(
                                `#select-session-${session}-${day}th`
                            );
                            selectMorning.disabled = false;

                            let index = arrConstrainstData.findIndex(
                                x => x.class == chkMorning.dataset.class
                            );
                            if (index > -1) {
                                let findConstraint = arrConstrainstData[
                                    index
                                ].constrainst.findIndex(
                                    x =>
                                        x.subject == item.id &&
                                        x.session == session &&
                                        x.part == 0 &&
                                        x.day == day
                                );
                                if (findConstraint == -1) {
                                    arrConstrainstData[index].constrainst.push({
                                        subject: item.id,
                                        session: session,
                                        day: day,
                                        level: 0,
                                        part: 0
                                    });
                                }
                            }
                        } else {
                            let index = arrConstrainstData.findIndex(
                                x => x.class == chkMorning.dataset.class
                            );
                            if (index > -1) {
                                let findConstraint = arrConstrainstData[
                                    index
                                ].constrainst.findIndex(
                                    x =>
                                        x.subject == item.id &&
                                        x.session == session &&
                                        x.part == 0 &&
                                        x.day == day
                                );

                                if (findConstraint > -1) {
                                    arrConstrainstData[
                                        index
                                    ].constrainst.splice(findConstraint, 1);
                                }
                            }
                        }
                        console.log(arrConstrainstData);
                    };

                    let selectMorning = document.getElementById(
                        `select-session-${session}-${day}th`
                    );

                    selectMorning.setAttribute("data-subject", item.id);
                    selectMorning.setAttribute("data-session", session);
                    selectMorning.setAttribute("data-day", day);

                    selectMorning.onchange = function() {
                        let index = arrConstrainstData.findIndex(
                            x => x.class == selectMorning.dataset.class
                        );
                        if (index > -1) {
                            let findConstraint = arrConstrainstData[
                                index
                            ].constrainst.findIndex(
                                x =>
                                    x.subject == item.id &&
                                    x.session == session &&
                                    x.part == 0 &&
                                    x.day == day
                            );

                            if (findConstraint > -1) {
                                arrConstrainstData[index].constrainst[
                                    findConstraint
                                ].level = selectMorning.value;
                            }
                        }
                        console.log(arrConstrainstData);
                    };

                    // set afternoon
                    let chkAfternoon = document.getElementById(
                        `session-pm-${session}-${day}th`
                    );
                    chkAfternoon.checked = false;
                    chkAfternoon.setAttribute("data-subject", item.id);
                    chkAfternoon.setAttribute("data-session", session);
                    chkAfternoon.setAttribute("data-day", day);

                    // set event
                    chkAfternoon.onclick = function() {
                        if (chkAfternoon.checked) {
                            let selectAfternoons = document.querySelector(
                                `#select-session-pm-${session}-${day}th`
                            );
                            selectAfternoons.disabled = false;

                            let index = arrConstrainstData.findIndex(
                                x => x.class == chkMorning.dataset.class
                            );
                            if (index > -1) {
                                let findConstraint = arrConstrainstData[
                                    index
                                ].constrainst.findIndex(
                                    x =>
                                        x.subject == item.id &&
                                        x.session == session &&
                                        x.part == 1 &&
                                        x.day == day
                                );
                                if (findConstraint == -1) {
                                    arrConstrainstData[index].constrainst.push({
                                        subject: item.id,
                                        session: session,
                                        day: day,
                                        level: 0,
                                        part: 1
                                    });
                                }
                            }
                            console.log(arrConstrainstData);
                        } else {
                            let index = arrConstrainstData.findIndex(
                                x => x.class == chkMorning.dataset.class
                            );
                            if (index > -1) {
                                let findConstraint = arrConstrainstData[
                                    index
                                ].constrainst.findIndex(
                                    x =>
                                        x.subject == item.id &&
                                        x.session == session &&
                                        x.part == 1 &&
                                        x.day == day
                                );

                                if (findConstraint > -1) {
                                    arrConstrainstData[
                                        index
                                    ].constrainst.splice(findConstraint, 1);
                                    console.log(arrConstrainstData);
                                }
                            }
                            console.log(arrConstrainstData);
                        }
                    };

                    let selectAfternoon = document.getElementById(
                        `select-session-pm-${session}-${day}th`
                    );

                    selectAfternoon.setAttribute("data-subject", item.id);
                    selectAfternoon.setAttribute("data-session", session);
                    selectAfternoon.setAttribute("data-day", day);
                    selectAfternoon.onchange = function() {
                        let index = arrConstrainstData.findIndex(
                            x => x.class == selectMorning.dataset.class
                        );
                        if (index > -1) {
                            let findConstraint = arrConstrainstData[
                                index
                            ].constrainst.findIndex(
                                x =>
                                    x.subject == item.id &&
                                    x.session == session &&
                                    x.part == 1 &&
                                    x.day == day
                            );

                            if (findConstraint > -1) {
                                arrConstrainstData[index].constrainst[
                                    findConstraint
                                ].level = selectAfternoon.value;
                                console.log(arrConstrainstData);
                            }
                        }
                    };
                }
            }

            if (checkbox.checked == false) {
                let chkClass = document.querySelector(".view");

                let index = arrConstrainstData.findIndex(
                    x => x.class == chkClass.dataset.class
                );
                let indexConstrainst = 0;
                arrConstrainstData[index].constrainst.forEach(item => {
                    if (item.subject == checkbox.dataset.subject) {
                        arrConstrainstData[index].constrainst[
                            indexConstrainst
                        ].splice(indexConstrainst, 1);
                    }
                    indexConstrainst++;
                });
            }
            console.log(arrConstrainstData);
        };

        tbodySubjects.appendChild(tr);
    });
    // set view data
    if (constrainstdata.length > 0) {
        arrClass.forEach(classItem => {
            let findClass = constrainstdata.findIndex(
                x => x.lop == classItem.id
            );
            if (findClass > -1) {
                let chkClass = document.querySelector(
                    `.chkClass[data-class="${classItem.id}"]`
                );
                chkClass.classList.add("selected");
                chkClass.checked = true;

                let itemConstraints = { class: classItem.id, constrainst: [] };
                let arrConst = constrainstdata.map(item => {
                    if (item.lop == classItem.id) {
                        let chkSubject = document.querySelector(
                            `.chk-subject[data-subject="${item.mon}"]`
                        );
                        if (chkSubject.checked == false) {
                            chkSubject.checked = true;
                            chkSubject.classList.add("selected");
                        }

                        return {
                            subject: item.mon,
                            session: item.tiet,
                            day: item.thu,
                            level: item.mamucrangbuoc,
                            part: item.buoi
                        };
                    }
                });
                itemConstraints.constrainst = arrConst;
                arrConstrainstData.push(itemConstraints);
            }
        });
        console.log(arrConstrainstData);
    }
}
// Save data
$("#btnluutietgvbuocphaico").click(function() {
    axios
        .post("addrangbuoctietgvbuocphaico", {
            idTeacher: document.getElementById("idgv").value,
            datatietnghi: JSON.stringify(arrConstrainstData)
        })
        .then(function(response) {
            var data = response.data;
            Swal.fire({
                title: "Lưu",
                text: "Đã lưu thành công",
                icon: "success",
                confirmButtonText: "OK"
            });
            $("#modaldangkytietbuocphaicogv").modal("hide");
            // $("#modaldangkytietbuocphaicogv").on(
            //     "hidden.bs.modal",
            //     function () {
            //         $(this).find("#formthemmoitietgvbuocphaico")[0].reset();
            //         // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
            //     }
            // );
            reloadgvthamgiagiangday();
        });
});

$("#btndongdangkytietbuocphaicogv").on("click", function() {
    $("#modaldangkytietbuocphaicogv").on("hidden.bs.modal", function(e) {
        $(this)
            .find("#formthemmoitietgvbuocphaico")[0]
            .reset();
        $("#tablechontietgvbuocphaico>tbody").empty();
    });
});

jQuery(document).ready(function() {
    jQuery("#modaldangkytietbuocphaicogv").on("hidden.bs.modal", function(e) {
        $(this)
            .find("#formthemmoitietgvbuocphaico")[0]
            .reset();
        $("#tablechontietgvbuocphaico>tbody").empty();
    });
});

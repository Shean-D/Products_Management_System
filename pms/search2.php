<?php
include 'system/function.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Product Management System</title>
    </head>
    <body>

        <form id="search" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="text" name="app_no" placeholder="Enter App. No">
            <input type="text" name="pat_id" placeholder="Enter Pat. ID">
            <input type="date" name="from" placeholder="Enter From Date">
            <input type="date" name="to" placeholder="Enter To Date">
            <select name="rep_type">
                <option value="">--</option>
                <option value="D">Daily</option>
                <option value="W">Weekly</option>
                <option value="M">Monthly</option>
                <option value="Y">Yearly</option>
            </select>
            <button type="submit">Search</button>
        </form>
        <?php
        extract($_POST);
        $db = dbConn();
        $where = null;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!empty($app_no)) {
                $where .= " appointment_no='$app_no' AND";
            }
            if (!empty($pat_id)) {
                $where .= " patient_id='$pat_id' AND";
            }

            if (!empty($from) && !empty($to)) {
                $where .= " appointment_date BETWEEN  '$from' AND '$to' AND";
            }

            if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = " WHERE $where";
            }
        }
        if ($rep_type == "D") {
            $sql = "SELECT appointment_date,count(appointment_id) AS mycount  FROM tb_appointment $where GROUP BY appointment_date";
        }
        if ($rep_type == "M") {
            $sql = "SELECT MONTH(appointment_date) AS Month,count(appointment_id) AS mycount  FROM tb_appointment $where GROUP BY MONTH(appointment_date)";
        }
        $result = $db->query($sql);
        $total = 0;
        ?>
        <div id="divData">
        <?php
        echo "<strong>Found " . $result->num_rows . " records</strong>";
        ?>
        <table border="1" width="100%" id="tblData">
            <thead>
                <tr>

                    <th>Appointment Date</th>
                    <th>No Appointments</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>

                        <td><?php
                            $dateObj = DateTime::createFromFormat('!m', $row['Month']);
                            echo $monthName = $dateObj->format('F');
                            ?></td>
                        <td><?php echo $row['mycount'] ?></td>
                    </tr>
                    <?php
                }
                ?>

            </tbody>
        </table>
            </div>
        <button onclick="exportTableToExcel('tblData', 'members-data')">Export Table Data To Excel File</button>
        <button onclick="Convert_HTML_To_PDF();">Convert HTML to PDF</button>
        <script src="js/html2canvas.min.js" type="text/javascript"></script>
        <script src="js/jspdf.min.js" type="text/javascript"></script>
        <script>
            function exportTableToExcel(tableID, filename = '') {
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById(tableID);
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

                // Specify file name
                filename = filename ? filename + '.xls' : 'excel_data.xls';

                // Create download link element
                downloadLink = document.createElement("a");

                document.body.appendChild(downloadLink);

                if (navigator.msSaveOrOpenBlob) {
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob(blob, filename);
                } else {
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                    // Setting the file name
                    downloadLink.download = filename;

                    //triggering the function
                    downloadLink.click();
            }
            }
            
            function Convert_HTML_To_PDF() {
                var elementHTML = document.getElementById('divData');

                html2canvas(elementHTML, {
                    useCORS: true,
                    onrendered: function (canvas) {
                        var pdf = new jsPDF('L', 'pt', 'letter');

                        var pageHeight = 680;
                        var pageWidth = 1900;
                        for (var i = 0; i <= elementHTML.clientHeight / pageHeight; i++) {
                            var srcImg = canvas;
                            var sX = 0;
                            var sY = pageHeight * i; // start 1 pageHeight down for every new page
                            var sWidth = pageWidth;
                            var sHeight = pageHeight;
                            var dX = 0;
                            var dY = 0;
                            var dWidth = pageWidth;
                            var dHeight = pageHeight;

                            window.onePageCanvas = document.createElement("canvas");
                            onePageCanvas.setAttribute('width', pageWidth);
                            onePageCanvas.setAttribute('height', pageHeight);
                            var ctx = onePageCanvas.getContext('2d');
                            ctx.drawImage(srcImg, sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight);

                            var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);
                            var width = onePageCanvas.width;
                            var height = onePageCanvas.clientHeight;

                            if (i > 0) // if we're on anything other than the first page, add another page
                                pdf.addPage(612, 864); // 8.5" x 12" in pts (inches*72)

                            pdf.setPage(i + 1); // now we declare that we're working on that page
                            pdf.addImage(canvasDataURL, 'PNG', 20, 40, (width * .62), (height * .62)); // add content to the page
                        }

                        // Save the PDF
                        pdf.save('document-html.pdf');
                    }
                });
            }


        </script>
    </body>
</html>


<main>
    <div class="containeri">
        <section class="grid-boxin">
         <div class="boxin-skills">
             <div class="boxin-card">
                 <span class="me-2"><img src="<?php echo(DIRIMG."./svg/pagamento.svg"); ?>"></span>
                 <h3 class="text-matrix">Pagamento</h3>
                 <p class="text-matrix">Acessar a tabela do Pagamento</p>
                 <button class="text-matrix acessar" data-target="acessar1">Visualizar</button>
             </div>
         </div>
         <div class="boxin-skills">
             <div class="boxin-card">
                 <span class="me-2"><img src="<?php echo(DIRIMG."./svg/recebimento.svg"); ?>"></span>
                 <h3 class="text-matrix">Recebimento</h3>
                 <p class="text-matrix">Acessar a tabela do recebimento</p>
                 <button class="text-matrix acessar" data-target="acessar2">Visualizar</button>
             </div>
         </div>
         <div class="boxin-skills">
             <div class="boxin-card">
                 <span class="me-2"><img src="<?php echo(DIRIMG."./svg/table.svg"); ?>"></span>
                 <h3 class="text-matrix">Notas</h3>
                 <p class="text-matrix">Acessar a tabela do recebimento</p>
                 <button class="text-matrix acessar" data-target="acessar3">Visualizar</button>
             </div>
         </div>
         <!--<div class="boxin-skills">-->
         <!--    <div class="boxin-card">-->
         <!--        <i class="bi bi-laptop-fill"></i>-->
         <!--        <h3>Recebimento</h3>-->
         <!--        <p>Acessar a tabela do recebimento</p>-->
         <!--        <button>Acessar</button>-->
         <!--    </div>-->
         <!--</div>-->
     </section>
        <section class="table tabela customers_table" id="acessar1" style="display: none;">
         <div class="table__header">
              <h1 class="text-matrix">PAG | REC | NT 1</h1>
             <div class="input-group">
                 <input type="search" placeholder="Pesquisar na Tabela...">
                 <img src="images/search.png" alt="">
             </div>
             <div class="export__file">
                 <label for="export-file" class="export__file-btn" title="Export File"><img src="<?php echo DIRIMG?>Home/folders.svg" alt="" width="32px"></label>
                 <input type="checkbox" id="export-file">
                 <div class="export__file-options">
                     <label>baixar Em</label>
                     <label for="export-file" id="toEXCEL">EXCEL <img src="<?php echo DIRIMG?>Home/excel.svg" alt=""></label>
                     <label for="export-file" id="toPDF">PDF <img src="<?php echo DIRIMG?>Home/pdf.svg" alt=""></label>
                     <label for="export-file" id="toCSV">CSV <img src="<?php echo DIRIMG?>Home/csv.svg" alt=""></label>
                     <label for="export-file" id="toJSON">JSON <img src="<?php echo DIRIMG?>Home/json.png" alt=""></label>
                 </div>
             </div>
         </div>
         <div class="table__body">
             <table>
                 <thead>
                     <tr>
                         <th class="text-matrix"> Status <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix">Últ. Período <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Customer <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Location <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Order Date <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Amount <span class="icon-arrow">&UpArrow;</span></th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="text-matrix"> 1 </td>
                         <td> <img src="images/Zinzu Chan Lee.jpg" alt="">Zinzu Chan Lee</td>
                         <td class="text-matrix"> Seoul </td>
                         <td> 17 Dec, 2022 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong> $128.90 </strong></td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 2 </td>
                         <td class="text-matrix"><img src="images/Jeet Saru.png" alt=""> Jeet Saru </td>
                         <td> Kathmandu </td>
                         <td> 27 Aug, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$5350.50</strong> </td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 3</td>
                         <td><img src="images/Sonal Gharti.jpg" alt=""> Sonal Gharti </td>
                         <td class="text-matrix"> Tokyo </td>
                         <td> 14 Mar, 2023 </td>
                         <td>
                             <p class="status shipped">Shipped</p>
                         </td>
                         <td> <strong>$210.40</strong> </td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 4</td>
                         <td><img src="images/Alson GC.jpg" alt=""> Alson GC </td>
                         <td class="text-matrix"> New Delhi </td>
                         <td> 25 May, 2023 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong>$149.70</strong> </td>
                     </tr>
                     <tr>
                         <td> 5</td>
                         <td><img src="images/Sarita Limbu.jpg" alt=""> Sarita Limbu </td>
                         <td> Paris </td>
                         <td> 23 Apr, 2023 </td>
                         <td>
                             <p class="status pending">Pending</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 6</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alex Gonley </td>
                         <td> London </td>
                         <td> 23 Apr, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 7</td>
                         <td><img src="images/Alson GC.jpg" alt=""> Jeet Saru </td>
                         <td> New York </td>
                         <td> 20 May, 2023 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 8</td>
                         <td><img src="images/Sarita Limbu.jpg" alt=""> Aayat Ali Khan </td>
                         <td> Islamabad </td>
                         <td> 30 Feb, 2023 </td>
                         <td>
                             <p class="status pending">Pending</p>
                         </td>
                         <td> <strong>$149.70</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                 </tbody>
             </table> 
         </div>
     </section>
        <section class="table tabela customers_table" id="acessar2" style="display: none;">
         <div class="table__header">
              <h1 class="text-matrix">PAG | REC | NT 2</h1>
             <div class="input-group">
                 <input type="search" placeholder="Pesquisar na Tabela...">
                 <img src="images/search.png" alt="">
             </div>
             <div class="export__file">
                 <label for="export-file" class="export__file-btn" title="Export File"><img src="<?php echo DIRIMG?>Home/folders.svg" alt="" width="32px"></label>
                 <input type="checkbox" id="export-file">
                 <div class="export__file-options">
                     <label>baixar Em</label>
                     <label for="export-file" id="toEXCEL">EXCEL <img src="<?php echo DIRIMG?>Home/excel.svg" alt=""></label>
                     <label for="export-file" id="toPDF">PDF <img src="<?php echo DIRIMG?>Home/pdf.svg" alt=""></label>
                     <label for="export-file" id="toCSV">CSV <img src="<?php echo DIRIMG?>Home/csv.svg" alt=""></label>
                     <label for="export-file" id="toJSON">JSON <img src="<?php echo DIRIMG?>Home/json.png" alt=""></label>
                 </div>
             </div>
         </div>
         <div class="table__body">
             <table>
                 <thead>
                     <tr>
                         <th class="text-matrix"> Id <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Customer <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Location <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Order Date <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Status <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Amount <span class="icon-arrow">&UpArrow;</span></th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="text-matrix"> 1 </td>
                         <td> <img src="images/Zinzu Chan Lee.jpg" alt="">Zinzu Chan Lee</td>
                         <td class="text-matrix"> Seoul </td>
                         <td> 17 Dec, 2022 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong> $128.90 </strong></td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 2 </td>
                         <td class="text-matrix"><img src="images/Jeet Saru.png" alt=""> Jeet Saru </td>
                         <td> Kathmandu </td>
                         <td> 27 Aug, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$5350.50</strong> </td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 3</td>
                         <td><img src="images/Sonal Gharti.jpg" alt=""> Sonal Gharti </td>
                         <td class="text-matrix"> Tokyo </td>
                         <td> 14 Mar, 2023 </td>
                         <td>
                             <p class="status shipped">Shipped</p>
                         </td>
                         <td> <strong>$210.40</strong> </td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 4</td>
                         <td><img src="images/Alson GC.jpg" alt=""> Alson GC </td>
                         <td class="text-matrix"> New Delhi </td>
                         <td> 25 May, 2023 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong>$149.70</strong> </td>
                     </tr>
                     <tr>
                         <td> 5</td>
                         <td><img src="images/Sarita Limbu.jpg" alt=""> Sarita Limbu </td>
                         <td> Paris </td>
                         <td> 23 Apr, 2023 </td>
                         <td>
                             <p class="status pending">Pending</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 6</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alex Gonley </td>
                         <td> London </td>
                         <td> 23 Apr, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 7</td>
                         <td><img src="images/Alson GC.jpg" alt=""> Jeet Saru </td>
                         <td> New York </td>
                         <td> 20 May, 2023 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 8</td>
                         <td><img src="images/Sarita Limbu.jpg" alt=""> Aayat Ali Khan </td>
                         <td> Islamabad </td>
                         <td> 30 Feb, 2023 </td>
                         <td>
                             <p class="status pending">Pending</p>
                         </td>
                         <td> <strong>$149.70</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                 </tbody>
             </table> 
         </div>
     </section>
        <section class="table tabela customers_table" id="acessar3" style="display: none;">
         <div class="table__header">
              <h1 class="text-matrix">PAG | REC | NT 3</h1>
             <div class="input-group">
                 <input type="search" placeholder="Pesquisar na Tabela...">
                 <img src="images/search.png" alt="">
             </div>
             <div class="export__file">
                 <label for="export-file" class="export__file-btn" title="Export File"><img src="<?php echo DIRIMG?>Home/folders.svg" alt="" width="32px"></label>
                 <input type="checkbox" id="export-file">
                 <div class="export__file-options">
                     <label>baixar Em</label>
                     <label for="export-file" id="toEXCEL">EXCEL <img src="<?php echo DIRIMG?>Home/excel.svg" alt=""></label>
                     <label for="export-file" id="toPDF">PDF <img src="<?php echo DIRIMG?>Home/pdf.svg" alt=""></label>
                     <label for="export-file" id="toCSV">CSV <img src="<?php echo DIRIMG?>Home/csv.svg" alt=""></label>
                     <label for="export-file" id="toJSON">JSON <img src="<?php echo DIRIMG?>Home/json.png" alt=""></label>
                 </div>
             </div>
         </div>
         <div class="table__body">
             <table>
                 <thead>
                     <tr>
                         <th class="text-matrix"> Id <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Customer <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Location <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Order Date <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Status <span class="icon-arrow">&UpArrow;</span></th>
                         <th class="text-matrix"> Amount <span class="icon-arrow">&UpArrow;</span></th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="text-matrix"> 1 </td>
                         <td> <img src="images/Zinzu Chan Lee.jpg" alt="">Zinzu Chan Lee</td>
                         <td class="text-matrix"> Seoul </td>
                         <td> 17 Dec, 2022 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong> $128.90 </strong></td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 2 </td>
                         <td class="text-matrix"><img src="images/Jeet Saru.png" alt=""> Jeet Saru </td>
                         <td> Kathmandu </td>
                         <td> 27 Aug, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$5350.50</strong> </td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 3</td>
                         <td><img src="images/Sonal Gharti.jpg" alt=""> Sonal Gharti </td>
                         <td class="text-matrix"> Tokyo </td>
                         <td> 14 Mar, 2023 </td>
                         <td>
                             <p class="status shipped">Shipped</p>
                         </td>
                         <td> <strong>$210.40</strong> </td>
                     </tr>
                     <tr>
                         <td class="text-matrix"> 4</td>
                         <td><img src="images/Alson GC.jpg" alt=""> Alson GC </td>
                         <td class="text-matrix"> New Delhi </td>
                         <td> 25 May, 2023 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong>$149.70</strong> </td>
                     </tr>
                     <tr>
                         <td> 5</td>
                         <td><img src="images/Sarita Limbu.jpg" alt=""> Sarita Limbu </td>
                         <td> Paris </td>
                         <td> 23 Apr, 2023 </td>
                         <td>
                             <p class="status pending">Pending</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 6</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alex Gonley </td>
                         <td> London </td>
                         <td> 23 Apr, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 7</td>
                         <td><img src="images/Alson GC.jpg" alt=""> Jeet Saru </td>
                         <td> New York </td>
                         <td> 20 May, 2023 </td>
                         <td>
                             <p class="status delivered">Delivered</p>
                         </td>
                         <td> <strong>$399.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 8</td>
                         <td><img src="images/Sarita Limbu.jpg" alt=""> Aayat Ali Khan </td>
                         <td> Islamabad </td>
                         <td> 30 Feb, 2023 </td>
                         <td>
                             <p class="status pending">Pending</p>
                         </td>
                         <td> <strong>$149.70</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                     <tr>
                         <td> 9</td>
                         <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                         <td> Dhaka </td>
                         <td> 22 Dec, 2023 </td>
                         <td>
                             <p class="status cancelled">Cancelled</p>
                         </td>
                         <td> <strong>$249.99</strong> </td>
                     </tr>
                 </tbody>
             </table> 
         </div>
     </section>
         
     </div>
</main>
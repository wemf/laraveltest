<div class="modal-confirm-direccion confirm-hide">
    <div class="shadow" onclick="confirm.hide();"></div>
    <div class="container">
    <div class="title"><h1 id="confirmtitle">Dirección</h1></div>
    <div class="blockx">
        <input type="text" id="resultado" class="form-control" readonly>
    </div>
    <div id="confirmsegment" class="segment">
        <div class="block">
            <select id="via" class="dir form-control">
                <option value="" disabled="" selected="selected">Tipo de vía</option>
                <option value="CL">Calle</option>
                <option value="CR">Carrera</option>
                <option value="AV">Avenida</option>
                <option value="DG">Diagonal</option>
                <option value="TV">Transversal</option>
                <option value="Aeropuerto">Aeropuerto</option>
                <option value="Apartado">Apartado</option>
                <option value="Asentamiento">Asentamiento</option>
                <option value="Autopista">Autopista</option>
                <option value="Carretera">Carretera</option>
                <option value="Central mayorista">Central mayorista</option>
                <option value="Centro comercial">Centro comercial</option>
                <option value="CIR">Circular</option>
                <option value="Corregimiento">Corregimiento</option>
                <option value="Finca">Finca</option>
                <option value="Glorieta">Glorieta</option>
                <option value="Invasión">Invasión</option>
                <option value="Kilómetro">kilómetro</option>
                <option value="Lote">Lote</option>
                <option value="Terminal">Terminal</option>
                <option value="Variante">Variante</option>
                <option value="Vereda">Vereda</option>
                <option value="Zona franca">Zona franca</option>
            </select>
        </div>
        <div class="block">
            <input type="text" placeholder="Número" id="numero" class="dir numeric form-control">
        </div>
        <div class="block">
            <select id="letracruce1" class="dir form-control">
                <option value="" selected="selected">Letra de cruce</option>
                <option value="A">A</option>
                <option value="AA">AA</option>
                <option value="AAA">AAA</option>
                <option value="AB">AB</option>
                <option value="AC">AC</option>
                <option value="AF">AF</option>
                <option value="B">B</option>
                <option value="BB">BB</option>
                <option value="BBB">BBB</option>
                <option value="BC">BC</option>
                <option value="BD">BD</option>
                <option value="BE">BE</option>
                <option value="C">C</option>
                <option value="CC">CC</option>
                <option value="CCC">CCC</option>
                <option value="D">D</option>
                <option value="DA">DA</option>
                <option value="DB">DB</option>
                <option value="DD">DD</option>
                <option value="DDD">DDD</option>
                <option value="E">E</option>
                <option value="EE">EE</option>
                <option value="EEE">EEE</option>
                <option value="F">F</option>
                <option value="FF">FF</option>
                <option value="FFF">FFF</option>
                <option value="G">G</option>
                <option value="GG">GG</option>
                <option value="GGG">GGG</option>
                <option value="H">H</option>
                <option value="HA">HA</option>
                <option value="HB">HB</option>
                <option value="HC">HC</option>
                <option value="HD">HD</option>
                <option value="HE">HE</option>
                <option value="HF">HF</option>
                <option value="HG">HG</option>
                <option value="I">I</option>
                <option value="IA">IA</option>
                <option value="IB">IB</option>
                <option value="IC">IC</option>
                <option value="ID">ID</option>
                <option value="IE">IE</option>
                <option value="IF">IF</option>
                <option value="IG">IG</option>
                <option value="IA">IA</option>
                <option value="IB">IB</option>
                <option value="IC">IC</option>
                <option value="ID">ID</option>
                <option value="IE">IE</option>
                <option value="IF">IF</option>
                <option value="IG">IG</option>
                <option value="J">J</option>
                <option value="JA">JA</option>
                <option value="JB">JB</option>
                <option value="JC">JC</option>
                <option value="JD">JD</option>
                <option value="JE">JE</option>
                <option value="JF">JF</option>
                <option value="JG">JG</option>
                <option value="K">K</option>
                <option value="KA">KA</option>
                <option value="KB">KB</option>
                <option value="KC">KC</option>
                <option value="KD">KD</option>
                <option value="KE">KE</option>
                <option value="KF">KF</option>
                <option value="KG">KG</option>
                <option value="L">L</option>
                <option value="LA">LA</option>
                <option value="LB">LB</option>
                <option value="LC">LC</option>
                <option value="LD">LD</option>
                <option value="LE">LE</option>
                <option value="LF">LF</option>
                <option value="LG">LG</option>
                <option value="M">M</option>
                <option value="MA">MA</option>
                <option value="MB">MB</option>
                <option value="MC">MC</option>
                <option value="MD">MD</option>
                <option value="ME">ME</option>
                <option value="MF">MF</option>
                <option value="MG">MG</option>
                <option value="N">N</option>
                <option value="NA">NA</option>
                <option value="NB">NB</option>
                <option value="NC">NC</option>
                <option value="ND">ND</option>
                <option value="NE">NE</option>
                <option value="NF">NF</option>
                <option value="NG">NG</option>
                <option value="O">O</option>
                <option value="OA">OA</option>
                <option value="OB">OB</option>
                <option value="OC">OC</option>
                <option value="OD">OD</option>
                <option value="OE">OE</option>
                <option value="OF">OF</option>
                <option value="OG">OG</option>
                <option value="P">P</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PC">PC</option>
                <option value="PD">PD</option>
                <option value="PE">PE</option>
                <option value="PF">PF</option>
                <option value="PG">PG</option>
                <option value="Q">Q</option>
                <option value="QA">QA</option>
                <option value="QB">QB</option>
                <option value="QC">QC</option>
                <option value="QD">QD</option>
                <option value="QE">QE</option>
                <option value="QF">QF</option>
                <option value="QG">QG</option>
                <option value="R">R</option>
                <option value="RA">RA</option>
                <option value="RB">RB</option>
                <option value="RC">RC</option>
                <option value="RD">RD</option>
                <option value="RE">RE</option>
                <option value="RF">RF</option>
                <option value="RG">RG</option>
                <option value="S">S</option>
                <option value="SA">SA</option>
                <option value="SB">SB</option>
                <option value="SC">SC</option>
                <option value="SD">SD</option>
                <option value="SE">SE</option>
                <option value="SF">SF</option>
                <option value="SG">SG</option>
                <option value="T">T</option>
                <option value="TA">TA</option>
                <option value="TB">TB</option>
                <option value="TC">TC</option>
                <option value="TD">TD</option>
                <option value="TE">TE</option>
                <option value="TF">TF</option>
                <option value="TG">TG</option>
                <option value="U">U</option>
                <option value="UA">UA</option>
                <option value="UB">UB</option>
                <option value="UC">UC</option>
                <option value="UD">UD</option>
                <option value="UE">UE</option>
                <option value="UF">UF</option>
                <option value="UG">UG</option>
                <option value="V">V</option>
                <option value="VA">VA</option>
                <option value="VB">VB</option>
                <option value="VC">VC</option>
                <option value="VD">VD</option>
                <option value="VE">VE</option>
                <option value="VF">VF</option>
                <option value="VG">VG</option>
                <option value="X">X</option>
                <option value="XA">XA</option>
                <option value="XB">XB</option>
                <option value="XC">XC</option>
                <option value="XD">XD</option>
                <option value="XE">XE</option>
                <option value="XF">XF</option>
                <option value="XG">XG</option>
                <option value="Y">Y</option>
                <option value="YA">YA</option>
                <option value="YB">YB</option>
                <option value="YC">YC</option>
                <option value="YD">YD</option>
                <option value="YE">YE</option>
                <option value="YF">YF</option>
                <option value="YG">YG</option>
                <option value="Z">Z</option>
                <option value="ZA">ZA</option>
                <option value="ZB">ZB</option>
                <option value="ZC">ZC</option>
                <option value="ZD">ZD</option>
                <option value="ZE">ZE</option>
                <option value="ZF">ZF</option>
                <option value="ZG">ZG</option>
            </select>
        </div>
        <div class="block">
            <select id="puntocardinal1" class="dir form-control">
                <option value="" selected="selected">Punto cardinal</option>
                <option value="Este">Este</option>
                <option value="Norte">Norte</option>
                <option value="Oeste">Oeste</option>
                <option value="Sur">Sur</option>
            </select>
        </div>
        <div class="block">
            <input type="text" id="interseccion" placeholder="No intersección" class="dir numeric form-control">
        </div>        
        <div class="block">
            <select id="letracruce2" class="dir form-control">
                <option value="" selected="selected">Letra de cruce</option>
                <option value="A">A</option>
                <option value="AA">AA</option>
                <option value="AAA">AAA</option>
                <option value="AB">AB</option>
                <option value="AC">AC</option>
                <option value="AF">AF</option>
                <option value="B">B</option>
                <option value="BB">BB</option>
                <option value="BBB">BBB</option>
                <option value="BC">BC</option>
                <option value="BD">BD</option>
                <option value="BE">BE</option>
                <option value="C">C</option>
                <option value="CC">CC</option>
                <option value="CCC">CCC</option>
                <option value="D">D</option>
                <option value="DA">DA</option>
                <option value="DB">DB</option>
                <option value="DD">DD</option>
                <option value="DDD">DDD</option>
                <option value="E">E</option>
                <option value="EE">EE</option>
                <option value="EEE">EEE</option>
                <option value="F">F</option>
                <option value="FF">FF</option>
                <option value="FFF">FFF</option>
                <option value="G">G</option>
                <option value="GG">GG</option>
                <option value="GGG">GGG</option>
                <option value="H">H</option>
                <option value="HA">HA</option>
                <option value="HB">HB</option>
                <option value="HC">HC</option>
                <option value="HD">HD</option>
                <option value="HE">HE</option>
                <option value="HF">HF</option>
                <option value="HG">HG</option>
                <option value="I">I</option>
                <option value="IA">IA</option>
                <option value="IB">IB</option>
                <option value="IC">IC</option>
                <option value="ID">ID</option>
                <option value="IE">IE</option>
                <option value="IF">IF</option>
                <option value="IG">IG</option>
                <option value="IA">IA</option>
                <option value="IB">IB</option>
                <option value="IC">IC</option>
                <option value="ID">ID</option>
                <option value="IE">IE</option>
                <option value="IF">IF</option>
                <option value="IG">IG</option>
                <option value="J">J</option>
                <option value="JA">JA</option>
                <option value="JB">JB</option>
                <option value="JC">JC</option>
                <option value="JD">JD</option>
                <option value="JE">JE</option>
                <option value="JF">JF</option>
                <option value="JG">JG</option>
                <option value="K">K</option>
                <option value="KA">KA</option>
                <option value="KB">KB</option>
                <option value="KC">KC</option>
                <option value="KD">KD</option>
                <option value="KE">KE</option>
                <option value="KF">KF</option>
                <option value="KG">KG</option>
                <option value="L">L</option>
                <option value="LA">LA</option>
                <option value="LB">LB</option>
                <option value="LC">LC</option>
                <option value="LD">LD</option>
                <option value="LE">LE</option>
                <option value="LF">LF</option>
                <option value="LG">LG</option>
                <option value="M">M</option>
                <option value="MA">MA</option>
                <option value="MB">MB</option>
                <option value="MC">MC</option>
                <option value="MD">MD</option>
                <option value="ME">ME</option>
                <option value="MF">MF</option>
                <option value="MG">MG</option>
                <option value="N">N</option>
                <option value="NA">NA</option>
                <option value="NB">NB</option>
                <option value="NC">NC</option>
                <option value="ND">ND</option>
                <option value="NE">NE</option>
                <option value="NF">NF</option>
                <option value="NG">NG</option>
                <option value="O">O</option>
                <option value="OA">OA</option>
                <option value="OB">OB</option>
                <option value="OC">OC</option>
                <option value="OD">OD</option>
                <option value="OE">OE</option>
                <option value="OF">OF</option>
                <option value="OG">OG</option>
                <option value="P">P</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PC">PC</option>
                <option value="PD">PD</option>
                <option value="PE">PE</option>
                <option value="PF">PF</option>
                <option value="PG">PG</option>
                <option value="Q">Q</option>
                <option value="QA">QA</option>
                <option value="QB">QB</option>
                <option value="QC">QC</option>
                <option value="QD">QD</option>
                <option value="QE">QE</option>
                <option value="QF">QF</option>
                <option value="QG">QG</option>
                <option value="R">R</option>
                <option value="RA">RA</option>
                <option value="RB">RB</option>
                <option value="RC">RC</option>
                <option value="RD">RD</option>
                <option value="RE">RE</option>
                <option value="RF">RF</option>
                <option value="RG">RG</option>
                <option value="S">S</option>
                <option value="SA">SA</option>
                <option value="SB">SB</option>
                <option value="SC">SC</option>
                <option value="SD">SD</option>
                <option value="SE">SE</option>
                <option value="SF">SF</option>
                <option value="SG">SG</option>
                <option value="T">T</option>
                <option value="TA">TA</option>
                <option value="TB">TB</option>
                <option value="TC">TC</option>
                <option value="TD">TD</option>
                <option value="TE">TE</option>
                <option value="TF">TF</option>
                <option value="TG">TG</option>
                <option value="U">U</option>
                <option value="UA">UA</option>
                <option value="UB">UB</option>
                <option value="UC">UC</option>
                <option value="UD">UD</option>
                <option value="UE">UE</option>
                <option value="UF">UF</option>
                <option value="UG">UG</option>
                <option value="V">V</option>
                <option value="VA">VA</option>
                <option value="VB">VB</option>
                <option value="VC">VC</option>
                <option value="VD">VD</option>
                <option value="VE">VE</option>
                <option value="VF">VF</option>
                <option value="VG">VG</option>
                <option value="X">X</option>
                <option value="XA">XA</option>
                <option value="XB">XB</option>
                <option value="XC">XC</option>
                <option value="XD">XD</option>
                <option value="XE">XE</option>
                <option value="XF">XF</option>
                <option value="XG">XG</option>
                <option value="Y">Y</option>
                <option value="YA">YA</option>
                <option value="YB">YB</option>
                <option value="YC">YC</option>
                <option value="YD">YD</option>
                <option value="YE">YE</option>
                <option value="YF">YF</option>
                <option value="YG">YG</option>
                <option value="Z">Z</option>
                <option value="ZA">ZA</option>
                <option value="ZB">ZB</option>
                <option value="ZC">ZC</option>
                <option value="ZD">ZD</option>
                <option value="ZE">ZE</option>
                <option value="ZF">ZF</option>
                <option value="ZG">ZG</option>
            </select>
        </div>
        <div class="block">
            <select id="puntocardinal2" class="dir form-control">
                <option value="" selected="selected">Punto cardinal</option>
                <option value="Este">Este</option>
                <option value="Norte">Norte</option>
                <option value="Oeste">Oeste</option>
                <option value="Sur">Sur</option>
            </select>
        </div>
        <div class="block">
            <input type="text" id="numero2" placeholder="Número" class="dir numeric form-control">
        </div>
        <div class="block">
            <select id="puntocardinal3" class="dir form-control">
                <option value="" selected="selected">tipo</option>
                <option value="Apto">Apartamento</option>
                <option value="Edificio">Edificio</option>
                <option value="Local">Local</option>
            </select>
        </div>
        <div class="block">
            <input type="text" id="numero3" placeholder="Número" class="dir numeric form-control">
            <input type="hidden" id="idmodal">
        </div>
    </div>
    <div class="buttons">
        <button type="button" id="confirmSuccess" class="btn btn-success confirmDir" >Aceptar</button>
        <button type="button" class="btn btn-primary" onclick="direccion.hide();">Cancelar</button>
    </div>
    </div>
</div>

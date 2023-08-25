<?php
<div class="filterPopup" id="filterPopup" style="display: none">
                        <div class="filter">
                            <form method="get" action="index.php">
                                <select name="sortbydate">
                                    <option value="ASC">Awal ke Akhir</option>
                                    <option value="DESC">Akhir ke Awal</option>
                                </select>
                                <input type="hidden" name="filter" value="sortbydate">
                                <input type="submit" class="filter-ops" value="Urutkan">
                            </form>

                            <form method="get" action="index.php">
                                <select name="sortbycategory">
                                    <option value="SCADA NON REDUNDANT">SCADA NON REDUNDANT</option>
                                    <option value="NON SCADA">NON SCADA</option>
                                </select>
                                <input type="hidden" name="filter" value="sortbycategory">
                                <input type="submit" class="filter-ops" value="Filter">
                            </form>

                            <form method="get" action="index.php">
                                <select name="sortbyproduk">
                                    <option value="IP VPN">IP VPN</option>
                                    <option value="INTERNET">INTERNET</option>
                                    <option value="Clear Channel">Clear Channel</option>
                                    <option value="METRONET">METRONET</option>
                                    <option value="VSAT IP">VSAT IP</option>
                                </select>
                                <input type="hidden" name="filter" value="sortbyproduk">
                                <input type="submit" class="filter-ops" value="Filter">
                            </form>

                            <form method="get" action="index.php">
                                <select name="sortbyasman">
                                    <option value="SUMBAR">SUMBAR</option>
                                    <option value="JAMBI">JAMBI</option>
                                </select>
                                <input type="hidden" name="filter" value="sortbyasman">
                                <input type="submit" class="filter-ops" value="Filter">
                            </form>
                        </div>
                    </div>
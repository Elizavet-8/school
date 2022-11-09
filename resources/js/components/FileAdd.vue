<template>
    <div class="section-file-row">
        <div class="form-group-file-column">
            <label class="form-group-file">
                <input type="file" @change="imgSelected" name="image" class="form-control-file" multiple
                       accept="doc/pdf/docx/zip">
                <span class="form-icon-file">
                <svg class="form-svg-file" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512.000000 512.000000"
                     preserveAspectRatio="xMidYMid meet">
<g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
   fill="#000000" stroke="none">
<path d="M705 4471 c-11 -5 -29 -19 -40 -31 -20 -22 -20 -38 -23 -1761 -2
-1931 -7 -1785 63 -1815 29 -12 290 -14 1751 -14 1542 0 1719 2 1749 16 70 33
65 -104 65 1798 0 1461 -2 1722 -14 1751 -30 70 113 65 -1803 64 -950 0 -1737
-4 -1748 -8z m3345 -1278 c0 -1052 0 -1077 -19 -1058 -10 11 -210 251 -445
533 -275 330 -437 517 -454 523 -43 17 -84 3 -129 -44 -22 -23 -244 -287 -493
-587 -249 -300 -461 -554 -471 -565 -19 -19 -23 -15 -306 267 -159 157 -299
289 -311 293 -59 18 -79 3 -322 -240 -129 -129 -238 -235 -242 -235 -10 0 -11
2174 -1 2183 3 4 723 7 1600 7 l1593 0 0 -1077z m-476 -844 l476 -571 0 -354
0 -354 -1600 0 -1600 0 0 348 0 347 268 268 267 267 280 -281 c154 -154 292
-287 307 -295 35 -18 88 -18 113 0 11 8 241 280 510 605 270 324 493 590 497
590 3 1 220 -256 482 -570z"/>
<path d="M1813 3825 c-81 -22 -132 -52 -193 -114 -102 -102 -145 -241 -116
-378 19 -91 46 -144 108 -210 94 -98 196 -139 332 -131 114 7 182 36 262 110
177 166 187 423 24 601 -104 114 -268 162 -417 122z m212 -229 c61 -33 98 -94
103 -170 3 -49 0 -71 -16 -102 -85 -165 -299 -165 -384 0 -30 59 -22 151 18
208 65 93 178 119 279 64z"/>
</g>
</svg>
            </span>
                <div class="form-control-file-text" v-if="!imgs || !imgs.length">Прикрепите изображение</div>
                <div v-else class="form-control-file-text" v-for="img in imgs" :key="img.name">{{ img.name }}</div>
            </label>
        </div>
        <div class="form-group-file-column">
            <label class="form-group-file">
                <input type="file" @change="fileSelected" name="file" class="form-control-file" multiple
                       accept="doc/pdf/docx/zip">
                <span class="form-icon-file">
                <svg class="form-svg-file form-svg-file_small" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                                                                                                                                             fill="#000000" stroke="none">
                        <path d="M3440 5105 c-214 -37 -363 -100 -528 -225 -91 -69 -2437 -2416 -2504
                            -2505 -348 -462 -399 -1073 -133 -1583 276 -528 844 -839 1433 -784 293 28
                            515 112 762 290 96 69 2491 2469 2522 2527 37 70 24 166 -31 229 -46 52 -158
                            73 -224 40 -18 -9 -585 -568 -1262 -1243 -950 -948 -1246 -1239 -1302 -1275
                            -361 -235 -831 -235 -1186 1 -440 292 -604 864 -387 1348 80 178 64 161 1304
                            1403 639 640 1194 1190 1234 1223 130 105 264 156 437 166 258 15 494 -98 656
                            -312 124 -164 159 -378 94 -571 -58 -173 -22 -133 -1074 -1187 -531 -532 -986
                            -981 -1011 -998 -111 -74 -285 -90 -401 -37 -62 28 -119 81 -145 136 -38 79
                            -27 207 28 317 13 26 308 328 834 855 568 570 818 826 829 852 40 97 -13 221
                            -110 258 -46 18 -119 14 -162 -9 -21 -12 -402 -383 -854 -833 -859 -856 -872
                            -870 -932 -1018 -44 -109 -51 -148 -51 -300 -1 -113 3 -158 17 -204 40 -130
                            116 -246 217 -330 57 -47 185 -109 275 -132 97 -25 333 -26 425 0 99 27 240
                            99 322 165 122 100 1928 1915 1995 2007 151 206 225 421 224 655 0 247 -77
                            457 -239 660 -252 314 -683 481 -1072 414z"/>
                                            </g></svg>
            </span>
                <div class="form-control-file-text" v-if="!files || !files.length">Прикрепите документ</div>
                <div v-else  class="form-control-file-text" v-for="file in files" :key="file.name">{{ file.name }}</div>
            </label>
        </div>
    </div>
</template>

<script>
export default {
    name: "FileAdd",
    data() {
        return {
            files: null,
            imgs: null,
        }
    },
    methods: {
        fileSelected(e) {
            this.files = e.target.files
        },
        imgSelected(e) {
            this.imgs = e.target.files
        },
    }
}
</script>

<style scoped>

</style>

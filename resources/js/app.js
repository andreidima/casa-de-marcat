/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('vue2-datepicker', require('./components/DatePicker.vue').default);
Vue.component('html-to-paper', require('./components/HtmlToPaper.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if (document.querySelector('#app1')) {
    const app1 = new Vue({
        el: '#app1'
    });
    const options = {
        name: '_blank',
        specs: [
            'fullscreen=yes',
            'titlebar=yes',
            'scrollbars=yes'
        ],
        styles: [
            'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
            'https://unpkg.com/kidlat-css/css/kidlat.css'
        ]
    };
}

if (document.querySelector('#app2')) {
    const app = new Vue({
        el: '#app2',
    });
}

if (document.querySelector('#adaugare_modificare_produse')) {
    const app1 = new Vue({
        el: '#adaugare_modificare_produse',
        data: {
            categorie: categorieVeche,
            subcategorii: '',
            subcategorie: subcategorieVeche
        },
        created: function () {
            this.getSubcategorii()
        },
        methods: {
            getSubcategorii: function () {
                axios.get('/produse/axios_date_produs', {
                    params: {
                        request: 'subcategorii',
                        categorie: this.categorie,
                    }
                })
                    .then(function (response) {
                        app1.subcategorii = '',

                            app1.subcategorii = response.data.subcategorii;
                    });
            },
        }
    });
}

if (document.querySelector('#cautare_produse_vandute')) {
    const app1 = new Vue({
        el: '#cautare_produse_vandute'
    });
}

if (document.querySelector('#produse')) {
    const app = new Vue({
        el: '#produse',
        // methods: {
        //     formfocus() {
        //         document.getElementById("search_cod_de_bare").focus();
        //     }
        // },
        // mounted() {
        //     this.formfocus()
        // }
    });
}

if (document.querySelector('#vanzari')) {
    const app = new Vue({
        el: '#vanzari',
        data: {
            cod_de_bare: codDeBareVechi,
            pret: '',
        },
        created: function () {
            this.getPret()
        },
        methods: {
            getPret: function () {
                axios.get('/produse/axios_date_produs', {
                    params: {
                        request: 'pret',
                        cod_de_bare: this.cod_de_bare,
                    }
                })
                    .then(function (response) {
                        app.pret = response.data.pret;
                    });
            },
            formfocus() {
                document.getElementById("cod_de_bare").focus();
            }
        },
        mounted() {
            this.formfocus()
        }
    });
}

if (document.querySelector('#generare-factura')) {
    const app = new Vue({
        el: '#generare-factura',
        data: {
            client_deja_inregistrat: clientVechi,
            clienti: clientiExistenti,
            client_firma: clientVechiFirma,
            client_nr_reg_com: clientVechiNr_reg_com,
            client_cif_cnp: clientVechiCif_cnp,
            client_adresa: clientVechiAdresa,
            client_delegat: clientVechiDelegat,
            client_seria_nr_buletin: clientVechiSeria_nr_buletin,
            client_telefon: clientVechiTelefon,
        },
        // created: function () {
        //     this.getPret()
        // },
        methods: {
            getDateClient: function () {
                for (var i=0; i<this.clienti.length; i++){
                    if (this.clienti[i].id == this.client_deja_inregistrat){
                        this.client_firma = this.clienti[i].firma;
                        this.client_nr_reg_com = this.clienti[i].nr_reg_com;
                        this.client_cif_cnp = this.clienti[i].cif_cnp;
                        this.client_adresa = this.clienti[i].adresa;
                        this.client_delegat = this.clienti[i].delegat;
                        this.client_seria_nr_buletin = this.clienti[i].seria_nr_buletin;
                        this.client_telefon = this.clienti[i].telefon;
                        return true;
                    }
                }
                this.client_firma = '';
                this.client_nr_reg_com = '';
                this.client_cif_cnp = '';
                this.client_adresa = '';
                this.client_delegat = '';
                this.client_seria_nr_buletin = '';
                this.client_telefon = '';

            },
            // formfocus() {
            //     document.getElementById("cod_de_bare").focus();
            // }
        },
        mounted() {
            // this.formfocus()
        }
    });
}

if (document.querySelector('#lucrari_vizualizare')) {
    const app = new Vue({
        el: '#lucrari_vizualizare',
        data: {
            lucrari: lucrari,
            lucrariSelectate: [],
            categorieSelectata: '',
            producatorSelectat: '',
            producatoriSelectati: '',
            modelSelectat: '',
            modeleSelectate: '',

            lucrariBifate: [],

            pretTotal: 0,
        },
        watch: {
            categorieSelectata: function () {
                var categorieSelectata = this.categorieSelectata;
                var lucrariSelectate = [];
                var producatoriSelectati = [];

                if (categorieSelectata){
                    this.lucrari.forEach(function (lucrare) {
                        if (lucrare.categorie == categorieSelectata) {
                            lucrariSelectate.push(lucrare);
                            if (!producatoriSelectati.includes(lucrare.producator)) {
                                producatoriSelectati.push(lucrare.producator)
                            }
                        }
                    });
                }
                this.lucrariSelectate = lucrariSelectate;
                this.producatoriSelectati = producatoriSelectati;
                this.producatorSelectat = '';
                this.modelSelectat = '';
                this.modeleSelectate = '';
                this.problemeSelectate = '';
                this.lucrariBifate = [];
                this.pretTotal = '';
            },
            producatorSelectat: function () {
                var categorieSelectata = this.categorieSelectata;
                var producatorSelectat = this.producatorSelectat;
                var lucrariSelectate = [];
                var modeleSelectate = [];

                if (!producatorSelectat) {
                    this.lucrari.forEach(function (lucrare) {
                        if (lucrare.categorie == categorieSelectata) {
                            lucrariSelectate.push(lucrare);
                        }
                    });
                } else {
                    this.lucrari.forEach(function (lucrare) {
                        if ( (lucrare.categorie == categorieSelectata) && (lucrare.producator == producatorSelectat) ){
                            lucrariSelectate.push(lucrare);
                            if (!modeleSelectate.includes(lucrare.model)) {
                                modeleSelectate.push(lucrare.model)
                            }
                        }
                    });
                }

                this.lucrariSelectate = lucrariSelectate;
                this.modeleSelectate = modeleSelectate;
                this.modelSelectat = '';
                this.problemeSelectate = '';
                this.lucrariBifate = [];
                this.pretTotal = '';
            },
            modelSelectat: function () {
                var categorieSelectata = this.categorieSelectata;
                var producatorSelectat = this.producatorSelectat;
                var modelSelectat = this.modelSelectat;
                var lucrariSelectate = [];
                var problemeSelectate = [];

                if (!modelSelectat) {
                    this.lucrari.forEach(function (lucrare) {
                        if ((lucrare.categorie == categorieSelectata) && (lucrare.producator == producatorSelectat)) {
                            lucrariSelectate.push(lucrare);
                        }
                    });
                } else {
                    this.lucrari.forEach(function (lucrare) {
                        if ((lucrare.categorie == categorieSelectata) && (lucrare.producator == producatorSelectat) && (lucrare.model == modelSelectat)) {
                            lucrariSelectate.push(lucrare);
                            if (!problemeSelectate.includes(lucrare.problema)) {
                                problemeSelectate.push(lucrare.problema)
                            }
                        }
                    });
                }

                this.lucrariSelectate = lucrariSelectate;
                this.problemeSelectate = problemeSelectate;
                this.lucrariBifate = [];
                this.pretTotal = '';
            },
            lucrariBifate: function () {
                var lucrariBifate = this.lucrariBifate;
                var pretTotal = 0;

                this.lucrariSelectate.forEach(function (lucrare) {
                    if (lucrariBifate.includes(lucrare.id)) {
                        pretTotal = pretTotal + lucrare.pret;
                    }
                });

                this.pretTotal = pretTotal;
            },
        },
        methods: {
        },
    });
}

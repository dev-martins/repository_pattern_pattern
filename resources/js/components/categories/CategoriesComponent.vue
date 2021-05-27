<template>
  <div>
    <div class="d-flex justify-content-end">
      <!-- button modal -->
      <button
        id="modal_open"
        class="btn btn-primary mb-3"
        data-toggle="modal"
        data-target="#myModal"
        @click="cadastro = true"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <!-- table users -->
    <table
      id="data_table"
      class="table table-striped table-bordered"
      style="width: 100%"
    >
      <thead>
        <tr>
          <th>Título</th>
          <th>URL</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories" :key="category.id">
          <td>{{ category.title }}</td>

          <td>{{ category.url }}</td>
          <td class="btn-group d-flex flex-row justify-content-center">
            <button
              class="btn btn-primary"
              @click="
                editarDados(
                  category.title,
                  category.url,
                  category.description,
                  category.id
                )
              "
            >
              <i class="far fa-edit"></i></button
            >
            <button
              class="btn btn-success"
              @click="
                editarDados(
                  category.title,
                  category.url,
                  category.description,
                  category.id
                )
              "
            >
              <i class="far fa-eye" style="color:white"></i>
            </button>
            <button class="btn btn-danger" @click="deletar(category.id)">
              <i class="far fa-trash-alt"></i>
            </button>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th>Título</th>
          <th>URL</th>
          <th>Actions</th>
        </tr>
      </tfoot>
    </table>
    <!-- The Modal -->
    <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              @click="limparModal()"
            >
              &times;
            </button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="title" class="col-form-label">Título:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="title"
                      v-model="title"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="url" class="col-form-label">URL:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="url"
                      v-model="url"
                    />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="description" class="col-form-label"
                      >Descrição:</label
                    >
                    <textarea
                      v-model="description"
                      class="form-control"
                      id="description"
                      rows="3"
                    ></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-danger btn-sm"
              data-dismiss="modal"
              @click="limparModal()"
            >
              Cancelar
            </button>
            <button
              v-if="cadastro == true"
              type="button"
              class="btn btn-primary btn-sm"
              @click="createCategory()"
            >
              Salvar
            </button>
            <button
              v-else
              type="button"
              class="btn btn-success btn-sm"
              @click="atualizar()"
            >
              Salvar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueToast from "vue-toast-notification";

Vue.use(VueToast);
var localHost = "http://127.0.0.1:8000";
export default {
  data() {
    return {
      categories: [],
      cadastro: true,
      title: "",
      url: "",
      id: "",
      description: "",
      options: {
        year: "numeric",
        month: "numeric",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
        second: "numeric",
        hour12: false,
        timeZone: "America/Sao_Paulo",
      },
    };
  },
  mounted() {
    this.listCategories();
  },
  methods: {
    loadTable() {
      $("#data_table").DataTable({
        language: {
          lengthMenu: "Exibindo &nbsp _MENU_ &nbsp registros por página",
          zeroRecords: "Nada encontrado - desculpe",
          info: "Mostrando página _PAGE_ de _PAGES_",
          infoEmpty: "Nenhum registro disponível",
          infoFiltered: "(filtrado de _MAX_ registros totais)",
        },
        retrieve: true,
      });
    },
    listCategories: function () {
      window.axios
        .get(`${localHost}/api/v1/categories`)
        .then((res) => {
          this.categories = res.data;
          setTimeout(() => {
            this.loadTable();
          }, 100);
        })
        .catch((erro) => {
          Vue.$toast.open({
            message: "Ocorreu um erro!",
            type: "error",
            position: "top-right",
            // all of other options may go here
          });
        });
    },
    createCategory() {
      this.sendData = new FormData();
      this.title == "" ? "" : this.sendData.append("title", this.title);
      this.url == "" ? "" : this.sendData.append("url", this.url);
      this.description == ""
        ? ""
        : this.sendData.append("description", this.description);

      window.axios
        .post(`${localHost}/api/v1/categories`, this.sendData)
        .then((res) => {
          Vue.$toast.open({
            message: res.data.msg,
            type: "success",
            position: "top-right",
            // all of other options may go here
          });

          this.listCategories();
          this.fecharModal();
        })
        .catch((erro) => {
          Vue.$toast.open({
            message: erro.response.data.msg,
            type: "error",
            position: "top-right",
            // all of other options may go here
          });
        });
    },
    deletar(id) {
      window.axios
        .delete(`${localHost}/api/v1/categories/${id}`, this.sendData)
        .then((res) => {
          Vue.$toast.open({
            message: "Categoria removida!",
            type: "success",
            position: "top-right",
            // all of other options may go here
          });
          this.listCategories();
        })
        .catch((erro) => {
          Vue.$toast.open({
            message: erro.response.data.msg,
            type: "error",
            position: "top-right",
            // all of other options may go here
          });
        });
    },
    atualizar() {
      window.axios
        .put(`${localHost}/api/v1/categories/${this.id}`, {
          title: this.title,
          url: this.url,
          description: this.description,
        })
        .then((res) => {
          Vue.$toast.open({
            message: "Categoria atualizada!",
            type: "success",
            position: "top-right",
            // all of other options may go here
          });
          this.listCategories();
          this.fecharModal();
        })
        .catch((erro) => {
          Vue.$toast.open({
            message: "Ocorreu um erro!",
            type: "error",
            position: "top-right",
            // all of other options may go here
          });
        });
    },
    fecharModal() {
      $(".close").trigger("click");
    },
    limparModal() {
      this.title = "";
      this.url = "";
      this.description = "";
    },
    titleModal(title) {
      $(".modal-title").text(title);
    },
    editarDados(title, url, description, id) {
      this.title = title;
      this.url = url;
      this.description = description;
      this.id = id;
      this.cadastro = false;
      this.titleModal("Editar dados");
      $("#myModal").modal();
    },
    convertDateTime(date) {
      date = date
        .replace(" ", "-")
        .replace(":", "-")
        .replace(":", "-")
        .replace("T", "-");
      var arr = date.split("-");

      date = new Intl.DateTimeFormat("default", this.options).format(
        new Date(arr[0], arr[1] - 1, arr[2], arr[3], arr[4], arr[5])
      );
      return date;
    },
    loadJs(url, callback) {
      jQuery.ajax({
        url: url,
        dataType: "script",
        success: callback,
        async: true,
      });
    },
    money: function (value) {
      parseFloat(value.toFixed(2)).toLocaleString("pt-BR", {
        currency: "BRL",
        minimumFractionDigits: 2,
      });
    },
  },
};
</script>
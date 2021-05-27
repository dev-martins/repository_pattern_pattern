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
          <th>Nome</th>
          <th>Email</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email, 1 }}</td>
          <td class="btn-group d-flex flex-row justify-content-center">
            <button
              class="btn btn-primary"
              @click="
                editarDados(
                  user.name,
                  user.email,
                )
              "
            >
              <i class="far fa-edit"></i>
            </button>
            <button
              class="btn btn-success"
              @click="
                editarDados(
                  user.name,
                  user.email,
                )
              "
            >
              <i class="far fa-eye" style="color: white"></i>
            </button>
            <button class="btn btn-danger" @click="deletar(user.id)">
              <i class="far fa-trash-alt"></i>
            </button>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Ações</th>
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
                    <label for="title" class="col-form-label">Nome:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="title"
                      v-model="name"
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
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="description" class="col-form-label"
                      >Categorias:</label
                    >
                    <select class="form-control" v-model="category_selected">
                      <option disabled selected>Escolha uma categoria</option>
                      <option v-for="product in products" :key="product.id" v-bind:value="product.category.id">
                        {{ product.category.title }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="price" class="col-form-label">Preço:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="price"
                      v-model="price"
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
      users: [],
      cadastro: true,
      name: "",
      email: "",
      id: "",
    };
  },
  mounted() {
    this.list();
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
    list: function () {
      window.axios
        .get(`${localHost}/api/v1/users`)
        .then((res) => {
          this.users = res.data;
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
    // createCategory() {
    //   this.sendData = new FormData();
    //   this.name == "" ? "" : this.sendData.append("name", this.name);
    //   this.price == "" ? "" : this.sendData.append("price", this.price);
    //   this.image == "" ? "" : this.sendData.append("image", this.image);
    //   this.url == "" ? "" : this.sendData.append("url", this.url);
    //   this.category_selected == ""
    //     ? ""
    //     : this.sendData.append("category_id", this.category_selected);
    //   this.description == ""
    //     ? ""
    //     : this.sendData.append("description", this.description);

    //   window.axios
    //     .post(`${localHost}/api/v1/products`, this.sendData)
    //     .then((res) => {
    //       Vue.$toast.open({
    //         message: res.data.msg,
    //         type: "success",
    //         position: "top-right",
    //         // all of other options may go here
    //       });

    //       this.listCategories();
    //       this.fecharModal();
    //     })
    //     .catch((erro) => {
    //       Vue.$toast.open({
    //         message: erro.response.data,
    //         type: "error",
    //         position: "top-right",
    //         // all of other options may go here
    //       });
    //     });
    // },
    // deletar(id) {
    //   window.axios
    //     .delete(`${localHost}/api/v1/products/${id}`, this.sendData)
    //     .then((res) => {
    //       Vue.$toast.open({
    //         message: "Produto removido!",
    //         type: "success",
    //         position: "top-right",
    //         // all of other options may go here
    //       });
    //       this.listCategories();
    //     })
    //     .catch((erro) => {
    //       Vue.$toast.open({
    //         message: "Ocorreu um erro!",
    //         type: "error",
    //         position: "top-right",
    //         // all of other options may go here
    //       });
    //     });
    // },
    // atualizar() {
    //   window.axios
    //     .put(`${localHost}/api/v1/products/${this.id}`, {
    //       name: this.name,
    //       url: this.url,
    //       description: this.description,
    //       price: this.price,
    //       image: this.image,
    //     })
    //     .then((res) => {
    //       Vue.$toast.open({
    //         message: "Categoria atualizada!",
    //         type: "success",
    //         position: "top-right",
    //         // all of other options may go here
    //       });
    //       this.listCategories();
    //       this.fecharModal();
    //     })
    //     .catch((erro) => {
    //       Vue.$toast.open({
    //         message: "Ocorreu um erro!",
    //         type: "error",
    //         position: "top-right",
    //         // all of other options may go here
    //       });
    //     });
    // },
    fecharModal() {
      $(".close").trigger("click");
    },
    limparModal() {
      this.name = "";
      this.email = "";
    },
    titleModal(name) {
      $(".modal-title").text(name);
    },
    editarDados(name, email) {
      this.name = name;
      this.email = email;
      this.cadastro = false;
      this.titleModal("Editar dados");
      $("#myModal").modal();
    },
    loadJs(url, callback) {
      jQuery.ajax({
        url: url,
        dataType: "script",
        success: callback,
        async: true,
      });
    },
  },
};
</script>
<template>
  <div class="container">
    <header>
      聊天室
    </header>

    <main>
      <div class="msg-list">
        <div v-for="item in messages"
             class="msg-item"
             :class="{'msg-own': item.type === 1}">
          <p>{{ item.msg }}</p>
        </div>
      </div>
    </main>

    <footer>
      <input class="input" type="text" v-model="msg" @keyup.enter="onSend">
      <button class="send btn-primary" @click="onSend">发送</button>
    </footer>
  </div>
</template>

<script>
const wsServer = import.meta.env.VITE_WS_HOST ?? '';
const websocket = new WebSocket(wsServer);

export default {
  data() {
    return {
      msg: "",
      messages: []
    }
  },
  created() {
    websocket.onmessage = (evt) => {
      this.messages.push({type: 2, msg: evt.data})
    };
    websocket.onclose = () => {
      if (confirm('连接已断开！')) {
        location.reload();
      }
    };
  },
  methods: {
    onSend() {
      if (this.msg) {
        websocket.send(this.msg)
        this.messages.push({type: 1, msg: this.msg})
        this.msg = ''
      }
    }
  }
}
</script>

<style>
* {
  margin: 0;
}

button {
  min-width: 64px;
  height: 36px;
  padding: 0 16px;
  border: none;
  border-radius: 32px;
  transition: box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
}

button:active {
  opacity: 0.8
}

button:hover {
  cursor: pointer;
  box-shadow: 0 5px 5px -3px rgba(0, 0, 0, 0.2),
  0 8px 10px 1px rgba(0, 0, 0, 0.14),
  0 3px 14px 2px rgba(0, 0, 0, 0.12);
}

.btn-primary {
  color: white;
  background-color: #6200ee;
}

button {
  min-width: 64px;
  height: 36px;
  padding: 0 16px;
  border: none;
  border-radius: 32px;
  transition: box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
}

button:active {
  opacity: 0.8
}

button:hover {
  cursor: pointer;
  box-shadow: 0 5px 5px -3px rgba(0, 0, 0, 0.2),
  0 8px 10px 1px rgba(0, 0, 0, 0.14),
  0 3px 14px 2px rgba(0, 0, 0, 0.12);
}

.btn-primary {
  color: white;
  background-color: #6200ee;
}

body {
  background-color: #f2f2f2;
}

.container {
  max-width: 750px;
  height: 100vh;
  margin-left: auto;
  margin-right: auto;
  background-color: #fff;

  display: flex;
  flex-direction: column;
}

header {
  padding: 16px;
  font-size: 1.5rem;
  text-align: center;
  box-shadow: 0 2px 4px -2px rgba(0, 0, 0, 0.5);
}

main {
  flex: auto;
  overflow-y: auto;
}

footer {
  display: flex;
  padding: 8px;
}

.msg-list {

}

.msg-item {
  display: flex;
  margin: 16px;
}

.msg-item > p {
  max-width: 60%;
  padding: 16px;
  background-color: #f2f2f2;
  text-align: justify;
}

.msg-own {
  flex-direction: row-reverse;
}

.input {
  flex: auto;
  margin: 0 8px;
  padding: 0 16px;
  height: 48px;
  background-color: #f2f2f2;
  border: none;
  border-radius: 4rem;
  outline: none;
  font-size: 1.2rem;
}

.send {
  margin: 0 8px;
  width: 88px;
  height: 48px;
  font-size: 1.05rem;
  white-space: nowrap
}
</style>
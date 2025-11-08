//It works in online...

import express from "express";
import { createServer } from "http";
import { Server } from "socket.io";

const app = express();
const server = createServer(app);
const io = new Server(server, {
  cors: { origin: "*" }
});

io.on("connection", socket => {
  console.log("User connected:", socket.id);

  socket.on("join-room", roomId => {
    socket.join(roomId);
    socket.to(roomId).emit("user-connected", socket.id);

    socket.on("offer", (offer, toId) => {
      io.to(toId).emit("offer", offer, socket.id);
    });
    socket.on("answer", (answer, toId) => {
      io.to(toId).emit("answer", answer, socket.id);
    });
    socket.on("candidate", (candidate, toId) => {
      io.to(toId).emit("candidate", candidate, socket.id);
    });

    socket.on("disconnect", () => {
      socket.to(roomId).emit("user-disconnected", socket.id);
    });
  });
});

server.listen(3000, () => console.log("🚀 Signaling server running on port 3000"));

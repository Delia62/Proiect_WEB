package org.example;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.PrintStream;
import java.net.Socket;
import java.nio.file.Files;
import java.nio.file.Paths;

class HttpReplay implements Runnable {
    private Socket socket;

    HttpReplay(Socket socket) {
        this.socket = socket;
    }

    public void run() {
        try {
            InputStream is = socket.getInputStream();
            OutputStream os = socket.getOutputStream();
            PrintStream ps = new PrintStream(os);

            // Citește prima linie a cererii
            byte[] buffer = new byte[1024];
            int read = is.read(buffer);
            String request = new String(buffer, 0, read);
            String[] requestLines = request.split("\r\n");
            String[] requestLine = requestLines[0].split(" ");
            String method = requestLine[0];
            String path = requestLine[1];

            // Determină tipul de conținut și calea fișierului de servit pe baza URL-ului cererii
            String filePath = "src/main/resources" + path;
            String contentType = "text/html";

            if (path.equals("/")) {
                filePath = "src/main/resources/home.html";
            } else if (path.endsWith(".css")) {
                contentType = "text/css";
            } else if (path.endsWith(".png")) {
                contentType = "image/png";
            } else if (path.endsWith(".jpg") || path.endsWith(".jpeg")) {
                contentType = "image/jpeg";
            }

            // Verifică dacă fișierul există
            if (Files.exists(Paths.get(filePath))) {
                byte[] body = Files.readAllBytes(Paths.get(filePath));
                ps.println("HTTP/1.1 200 OK");
                ps.println("Content-Type: " + contentType);
                ps.println("Content-Length: " + body.length);
                ps.println("Connection: Closed");
                ps.println();
                os.write(body);
            } else {
                // Răspunde cu 404 Not Found dacă fișierul nu există
                String body = "<html><body><h1>404 Not Found</h1></body></html>";
                ps.println("HTTP/1.1 404 Not Found");
                ps.println("Content-Type: text/html");
                ps.println("Content-Length: " + body.length());
                ps.println("Connection: Closed");
                ps.println();
                ps.println(body);
            }

            ps.flush();
            socket.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}

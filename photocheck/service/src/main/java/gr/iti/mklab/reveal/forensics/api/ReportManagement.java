package gr.iti.mklab.reveal.forensics.api;

import java.awt.Color;
import java.awt.Image;
import java.awt.image.BufferedImage;
import java.io.*;
import java.net.*;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Base64;
import java.util.concurrent.Callable;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.Future;

import com.mongodb.MongoClientURI;
import gr.iti.mklab.reveal.forensics.api.reports.*;

import com.drew.imaging.ImageProcessingException;

import gr.iti.mklab.reveal.forensics.maps.dwnoisevar.DWNoiseVarExtractor;
import gr.iti.mklab.reveal.forensics.meta.metadata.MetadataExtractor;
import gr.iti.mklab.reveal.forensics.meta.thumbnail.ThumbnailExtractor;

import com.google.gson.GsonBuilder;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import com.google.common.io.Files;
import com.mongodb.MongoClient;

import gr.iti.mklab.reveal.forensics.meta.gps.GPSExtractor;

import org.apache.commons.io.output.ByteArrayOutputStream;
import org.mongodb.morphia.Datastore;
import org.mongodb.morphia.Morphia;
import org.omg.CORBA.portable.ApplicationException;

import gr.iti.mklab.reveal.forensics.maps.dq.DQExtractor;
import gr.iti.mklab.reveal.forensics.maps.mediannoise.MedianNoiseExtractor;
import gr.iti.mklab.reveal.forensics.maps.ela.ELAExtractor;
import gr.iti.mklab.reveal.forensics.maps.ghost.GhostExtractor;
import gr.iti.mklab.reveal.forensics.maps.grids.GridsExtractor;
import gr.iti.mklab.reveal.forensics.maps.blocking.BlockingExtractor;
import gr.iti.mklab.reveal.forensics.util.ArtificialImages;
import javax.imageio.ImageIO;

import org.slf4j.LoggerFactory;
import ch.qos.logback.classic.Level;
import ch.qos.logback.classic.Logger;

public class ReportManagement {
    static int numGhostThreads = 4;
    static int numberOfThreads = 8;
    static int maxGhostImageSmallDimension = 768;
    static int computationTimeoutLimit = 900000;

    private static String url;

    static Logger root = (Logger) LoggerFactory.getLogger(Logger.ROOT_LOGGER_NAME);
    static {
        root.setLevel(Level.WARN);
    }

    public static SourceReport source(String request, String file_id, String file_name, String mime, String path) throws UnknownHostException, IOException {
        SourceReport report = new SourceReport();

        File mapFile = new File(path, file_name);
//        BufferedImage mapImage = ImageIO.read(mapFile);

        String outputUrl = "/" + request + "/" + file_id + "/";
        String outputPath = path + outputUrl;
        String fileName = "source.jpg";

        File outputFolder = new File(outputPath);
        if (!outputFolder.exists()) {
            outputFolder.mkdirs();
        }

        File copied = new File("src/test/resources/copiedWithGuava.txt");


        File outputFile = new File(outputPath, fileName);

        com.google.common.io.Files.copy(mapFile, outputFile);
//        ImageIO.write(mapImage, "png", outputFile);
/*
        ByteArrayOutputStream mapBuffer = new ByteArrayOutputStream();
        ImageIO.write(mapImage, "png", mapBuffer);
        mapBuffer.flush();
        byte[] mapInByte = mapBuffer.toByteArray();
        mapBuffer.close();

        String mapBase64 = Base64.getEncoder().encodeToString(mapInByte);

        report.map = "data:" + mime + ";base64," + mapBase64;
*/
        report.map = outputUrl + fileName;

        return report;
    }

    public static dqReport dq(String request, String file_id, String file_name, String mime, String path) throws UnknownHostException, IOException {
        dqReport dqReport = new dqReport();
        DQExtractor dqDetector = new DQExtractor(path + file_name);

        String outputUrl = "/" + request + "/" + file_id + "/";
        String outputPath = path + outputUrl;
        String fileName = "dq.png";

        File outputFolder = new File(outputPath);
        if (!outputFolder.exists()) {
            outputFolder.mkdirs();
        }

        File outputFile = new File(outputPath, fileName);
        ImageIO.write(dqDetector.displaySurface, "png", outputFile);
/*
        ByteArrayOutputStream mapBuffer = new ByteArrayOutputStream();
        ImageIO.write(dqDetector.displaySurface, "png", mapBuffer);
        mapBuffer.flush();
        byte[] mapInByte = mapBuffer.toByteArray();
        mapBuffer.close();

        String mapBase64 = Base64.getEncoder().encodeToString(mapInByte);

        dqReport.map = "data:" + mime + ";base64," + mapBase64;
*/
        dqReport.map = outputUrl + fileName;

        dqReport.maxValue = dqDetector.maxProbValue;
        dqReport.minvalue = dqDetector.minProbValue;
        dqReport.completed=true;

        return dqReport;
    }

    public static ELAReport ela(String request, String file_id, String file_name, String mime, String path) throws UnknownHostException, IOException {
        ELAReport elaReport = new ELAReport();
        ELAExtractor elaExtractor = new ELAExtractor(path + file_name);

        String outputUrl = "/" + request + "/" + file_id + "/";
        String outputPath = path + outputUrl;
        String fileName = "ela.png";

        File outputFolder = new File(outputPath);
        if (!outputFolder.exists()) {
            outputFolder.mkdirs();
        }

        File outputFile = new File(outputPath, fileName);
        ImageIO.write(elaExtractor.displaySurface, "png", outputFile);
/*
        ByteArrayOutputStream mapBuffer = new ByteArrayOutputStream();
        ImageIO.write(elaExtractor.displaySurface, "png", mapBuffer);
        mapBuffer.flush();
        byte[] mapInByte = mapBuffer.toByteArray();
        mapBuffer.close();

        String mapBase64 = Base64.getEncoder().encodeToString(mapInByte);

        elaReport.map = "data:" + mime + ";base64," + mapBase64;
*/
        elaReport.map = outputUrl + fileName;

        elaReport.maxValue = elaExtractor.elaMax;
        elaReport.minvalue = elaExtractor.elaMin;
        elaReport.completed = true;
        return elaReport;
    }

    public static BlockingReport blocking(String request, String file_id, String file_name, String mime, String path) throws UnknownHostException, IOException {
        BlockingReport blockingReport = new BlockingReport();
        BlockingExtractor blockingExtractor = new BlockingExtractor(path + file_name);

        String outputUrl = "/" + request + "/" + file_id + "/";
        String outputPath = path + outputUrl;
        String fileName = "blocking.png";

        File outputFolder = new File(outputPath);
        if (!outputFolder.exists()) {
            outputFolder.mkdirs();
        }

        File outputFile = new File(outputPath, fileName);
        ImageIO.write(blockingExtractor.displaySurface, "png", outputFile);
/*
        ByteArrayOutputStream mapBuffer = new ByteArrayOutputStream();
        ImageIO.write(blockingExtractor.displaySurface, "png", mapBuffer);
        mapBuffer.flush();
        byte[] mapInByte = mapBuffer.toByteArray();
        mapBuffer.close();

        String mapBase64 = Base64.getEncoder().encodeToString(mapInByte);

        blockingReport.map = "data:" + mime + ";base64," + mapBase64;
*/
        blockingReport.map = outputUrl + fileName;

        blockingReport.maxValue = blockingExtractor.blkmax;
        blockingReport.minValue = blockingExtractor.blkmin;
        blockingReport.completed = true;

        return blockingReport;
    }

    public static GhostReport ghost(String request, String file_id, String file_name, String mime, String path) throws UnknownHostException, IOException {
        int numThreads = 4;
        int maxImageSmallDimension = 768;

        GhostReport ghostReport=new GhostReport();
        GhostExtractor ghostExtractor = new GhostExtractor(path + file_name, maxImageSmallDimension, numThreads);

        String outputUrl = "/" + request + "/" + file_id + "/ghost/";
        String outputPath = path + outputUrl;
        String fileName;

        File outputFolder = new File(outputPath);
        if (!outputFolder.exists()) {
            outputFolder.mkdirs();
        }

        File outputFile;

        BufferedImage ghostMap;
        ByteArrayOutputStream mapBuffer;
        byte[] mapInByte;
        String mapBase64;

        for (int ghostMapInd = 0; ghostMapInd < ghostExtractor.ghostMaps.size(); ghostMapInd++) {
            ghostMap = ghostExtractor.ghostMaps.get(ghostMapInd);

            fileName = ghostMapInd + ".png";
            outputFile = new File(outputPath, fileName);
            ImageIO.write(ghostMap, "png", outputFile);
/*
            mapBuffer = new ByteArrayOutputStream();
            ImageIO.write(ghostMap, "png", mapBuffer);
            mapBuffer.flush();
            mapInByte = mapBuffer.toByteArray();
            mapBuffer.close();

            mapBase64 = Base64.getEncoder().encodeToString(mapInByte);

            ghostReport.maps.add("data:" + mime + ";base64," + mapBase64);
*/
            ghostReport.maps.add(outputUrl + fileName);

            ghostReport.differences = ghostExtractor.allDifferences;
            ghostReport.minQuality = ghostExtractor.qualityMin;
            ghostReport.maxQuality = ghostExtractor.qualityMax;
            ghostReport.qualities = ghostExtractor.ghostQualities;
            ghostReport.minValues = ghostExtractor.ghostMin;
            ghostReport.maxValues = ghostExtractor.ghostMax;
        }

        ghostReport.completed = true;

        return ghostReport;
    }

    public static DWNoiseReport dwNoise(String request, String file_id, String file_name, String mime, String path) throws UnknownHostException, IOException {
        DWNoiseReport dwNoiseReport = new DWNoiseReport();
        DWNoiseVarExtractor noiseExtractor = new DWNoiseVarExtractor(path + file_name);

        String outputUrl = "/" + request + "/" + file_id + "/";
        String outputPath = path + outputUrl;
        String fileName = "dwNoise.png";

        File outputFolder = new File(outputPath);
        if (!outputFolder.exists()) {
            outputFolder.mkdirs();
        }

        File outputFile = new File(outputPath, fileName);
        ImageIO.write(noiseExtractor.displaySurface, "png", outputFile);
/*
        ByteArrayOutputStream mapBuffer = new ByteArrayOutputStream();
        ImageIO.write(noiseExtractor.displaySurface, "png", mapBuffer);
        mapBuffer.flush();
        byte[] mapInByte = mapBuffer.toByteArray();
        mapBuffer.close();

        String mapBase64 = Base64.getEncoder().encodeToString(mapInByte);

        dwNoiseReport.map = "data:" + mime + ";base64," + mapBase64;
*/
        dwNoiseReport.map = outputUrl + fileName;

        dwNoiseReport.maxvalue = noiseExtractor.maxNoiseValue;
        dwNoiseReport.minValue = noiseExtractor.minNoiseValue;
        dwNoiseReport.completed = true;

        return dwNoiseReport;
    }

    public static MedianNoiseReport medianNoise(String request, String file_id, String file_name, String mime, String path) throws UnknownHostException, IOException {
        MedianNoiseReport medianNoiseReport = new MedianNoiseReport();
        MedianNoiseExtractor medianNoiseExtractor = new MedianNoiseExtractor(path + file_name);

        String outputUrl = "/" + request + "/" + file_id + "/";
        String outputPath = path + outputUrl;
        String fileName = "medianNoise.png";

        File outputFolder = new File(outputPath);
        if (!outputFolder.exists()) {
            outputFolder.mkdirs();
        }

        File outputFile = new File(outputPath, fileName);
        ImageIO.write(medianNoiseExtractor.displaySurface, "png", outputFile);
/*
        ByteArrayOutputStream mapBuffer = new ByteArrayOutputStream();
        ImageIO.write(medianNoiseExtractor.displaySurface, "png", mapBuffer);
        mapBuffer.flush();
        byte[] mapInByte = mapBuffer.toByteArray();
        mapBuffer.close();

        String mapBase64 = Base64.getEncoder().encodeToString(mapInByte);

        medianNoiseReport.map = "data:" + mime + ";base64," + mapBase64;
*/
        medianNoiseReport.map = outputUrl + fileName;

        medianNoiseReport.completed = true;

        return medianNoiseReport;
    }

    public static GridsReport grids(String request, String file_id, String file_name, String mime, String path) throws UnknownHostException, IOException {
        GridsReport gridsReport = new GridsReport();
        GridsExtractor gridsExtractor = new GridsExtractor(path + file_name);

        String outputUrl = "/" + request + "/" + file_id + "/grids/";
        String outputPath = path + outputUrl;
        String fileNameG = "normal.png";
        String fileNameGI = "inversed.png";

        File outputFolder = new File(outputPath);
        if (!outputFolder.exists()) {
            outputFolder.mkdirs();
        }

        File outputFileG = new File(outputPath, fileNameG);
        ImageIO.write(gridsExtractor.displaySurfaceG, "png", outputFileG);

        File outputFileGI = new File(outputPath, fileNameGI);
        ImageIO.write(gridsExtractor.displaySurfaceGI, "png", outputFileGI);
/*
        ByteArrayOutputStream mapBufferG = new ByteArrayOutputStream();
        ImageIO.write(gridsExtractor.displaySurfaceG, "png", mapBufferG);
        mapBufferG.flush();
        byte[] mapInByteG = mapBufferG.toByteArray();
        mapBufferG.close();

        String mapBase64G = Base64.getEncoder().encodeToString(mapInByteG);

        String mapG = "data:" + mime + ";base64," + mapBase64G;

        ByteArrayOutputStream mapBufferGI = new ByteArrayOutputStream();
        ImageIO.write(gridsExtractor.displaySurfaceGI, "png", mapBufferGI);
        mapBufferGI.flush();
        byte[] mapInByteGI = mapBufferGI.toByteArray();
        mapBufferGI.close();

        String mapBase64GI = Base64.getEncoder().encodeToString(mapInByteGI);

        String mapGI = "data:" + mime + ";base64," + mapBase64GI;

        gridsReport.mapG = mapG;
        gridsReport.mapGI = mapGI;
*/
        gridsReport.mapG = outputUrl + fileNameG;
        gridsReport.mapGI = outputUrl + fileNameGI;

        gridsReport.maxValueG = gridsExtractor.gridsmaxG;
        gridsReport.minValueG = gridsExtractor.gridsminG;
        gridsReport.maxValueGI = gridsExtractor.gridsmaxGI;
        gridsReport.minValueGI = gridsExtractor.gridsminGI;
        gridsReport.completed = true;

        return gridsReport;
    }

    private static class DQThread implements Callable {
        String sourceFile ="";
        File outputFile =null;
        public DQThread(String SourceFile, File outputFile){
            this.sourceFile =SourceFile;
            this.outputFile = outputFile;
        }
        @Override
        public dqReport call() {
            dqReport output=null;
            try {
                output= dqCalculation();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return output;
        }
        public dqReport dqCalculation() throws IOException {
            dqReport dqReport=new dqReport();
            DQExtractor dqDetector;
            dqDetector = new DQExtractor(sourceFile);
            ImageIO.write(dqDetector.displaySurface, "png", outputFile);
            ByteArrayOutputStream dqbytes = new ByteArrayOutputStream();
            ImageIO.write(dqDetector.displaySurface, "png", dqbytes);
            dqReport.map = outputFile.getCanonicalPath();
            dqReport.maxValue = dqDetector.maxProbValue;
            dqReport.minvalue = dqDetector.minProbValue;
            dqReport.completed=true;
            return dqReport;
        }
    }

    private static class noiseDWThread implements Callable {
        String sourceFile ="";
        File outputFile =null;
        public noiseDWThread(String sourceFile, File outputFile){
            this.sourceFile =sourceFile;
            this.outputFile = outputFile;
        }
        @Override
        public DWNoiseReport call() {
            DWNoiseReport output=null;
            try {
                output= noiseDWCalculation();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return output;
        }
        public DWNoiseReport noiseDWCalculation() throws IOException {
            DWNoiseReport dwNoiseReport=new DWNoiseReport();
            DWNoiseVarExtractor noiseExtractor;
            noiseExtractor = new DWNoiseVarExtractor(sourceFile);
            ImageIO.write(noiseExtractor.displaySurface, "png", outputFile);
            ByteArrayOutputStream noisebytes = new ByteArrayOutputStream();
            ImageIO.write(noiseExtractor.displaySurface, "png", noisebytes);

            dwNoiseReport.map = outputFile.getCanonicalPath();
            dwNoiseReport.maxvalue = noiseExtractor.maxNoiseValue;
            dwNoiseReport.minValue = noiseExtractor.minNoiseValue;
            dwNoiseReport.completed=true;
            return dwNoiseReport;
        }
    }

    private static class GhostThread implements Callable {
        String sourceFile ="";
        String baseFolder ="";
        int maxGhostImageSmallDimension;
        int numGhostThreads;
        public GhostThread(String sourceFile,String baseFolder, int maxGhostImageSmallDimension, int numGhostThreads){
            this.sourceFile =sourceFile;
            this.baseFolder =baseFolder;
            this.maxGhostImageSmallDimension = maxGhostImageSmallDimension;
            this.numGhostThreads=numGhostThreads;
        }
        @Override
        public GhostReport call() {
            GhostReport output=null;
            try {
                output= ghostCalculation(maxGhostImageSmallDimension, numGhostThreads);
            } catch (IOException e) {
                e.printStackTrace();
            }
            return output;
        }
        public GhostReport ghostCalculation(int maxImageSmallDimension, int numThreads) throws IOException {
            File ghostOutputfile;
            byte[] imageInByte;
            String ghostBase64; // convert to base64 the image file
            GhostReport ghostReport=new GhostReport();
            GhostExtractor ghostExtractor;
            ghostExtractor = new GhostExtractor(sourceFile, maxImageSmallDimension, numThreads);
            BufferedImage ghostMap;
            for (int ghostMapInd=0;ghostMapInd<ghostExtractor.ghostMaps.size();ghostMapInd++) {
                ghostOutputfile=new File(baseFolder, "GhostOutput" + String.format("%02d", ghostMapInd) + ".png");
                ghostMap=ghostExtractor.ghostMaps.get(ghostMapInd);
                ImageIO.write(ghostMap, "png", ghostOutputfile);
                ByteArrayOutputStream ghostbytes = new ByteArrayOutputStream();
                ImageIO.write(ghostMap, "png", ghostbytes);
                imageInByte = ghostbytes.toByteArray();

                ghostReport.maps.add(ghostOutputfile.getCanonicalPath());
                ghostReport.differences = ghostExtractor.allDifferences;
                ghostReport.minQuality = ghostExtractor.qualityMin;
                ghostReport.maxQuality = ghostExtractor.qualityMax;
                ghostReport.qualities = ghostExtractor.ghostQualities;
                ghostReport.minValues = ghostExtractor.ghostMin;
                ghostReport.maxValues = ghostExtractor.ghostMax;
            }
            ghostReport.completed=true;
            return ghostReport;
        }
    }

    private static class ELAThread implements Callable {
        String sourceFile ="";
        File outputFile =null;
        public ELAThread(String SourceFile,File outputFile){
            this.sourceFile =SourceFile;
            this.outputFile = outputFile;
        }
        @Override
        public ELAReport call() {
            ELAReport output=null;
            try {
                output= elaCalculation();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return output;
        }
        public ELAReport elaCalculation() throws IOException {
            ELAReport elaReport = new ELAReport();
            ELAExtractor elaExtractor;
            elaExtractor = new ELAExtractor(sourceFile);
            ImageIO.write(elaExtractor.displaySurface, "png", outputFile);
            ByteArrayOutputStream elabytes = new ByteArrayOutputStream();
            ImageIO.write(elaExtractor.displaySurface, "png", elabytes);

            elaReport.map = outputFile.getCanonicalPath();
            elaReport.maxValue = elaExtractor.elaMax;
            elaReport.minvalue = elaExtractor.elaMin;
            elaReport.completed = true;
            return elaReport;
        }
    }

    private static class BLKThread implements Callable {
        String sourceFile ="";
        File outputFile =null;
        public BLKThread(String sourceFile,File outputFile){
            this.sourceFile =sourceFile;
            this.outputFile = outputFile;
        }
        @Override
        public BlockingReport call() {
            BlockingReport output=null;
            try {
                output= blkCalculation();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return output;
        }
        public BlockingReport blkCalculation() throws IOException {
            BlockingReport blockingReport=new BlockingReport();
            BlockingExtractor blockingExtractor;
            blockingExtractor = new BlockingExtractor(sourceFile);
            ImageIO.write(blockingExtractor.displaySurface, "png", outputFile);
            ByteArrayOutputStream blockbytes = new ByteArrayOutputStream();
            ImageIO.write(blockingExtractor.displaySurface, "png", blockbytes);

            blockingReport.map = outputFile.getCanonicalPath();
            blockingReport.maxValue = blockingExtractor.blkmax;
            blockingReport.minValue = blockingExtractor.blkmin;
            blockingReport.completed=true;
            return blockingReport;
        }
    }

    private static class MedianNoiseThread implements Callable {
        String sourceFile ="";
        File outputFile =null;
        public MedianNoiseThread(String sourceFile,File outputFile){
            this.sourceFile =sourceFile;
            this.outputFile = outputFile;
        }
        @Override
        public MedianNoiseReport call() {
            MedianNoiseReport output=null;
            try {
                output= medianNoiseCalculation();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return output;
        }
        public MedianNoiseReport medianNoiseCalculation() throws IOException {
            MedianNoiseReport medianNoiseReport=new MedianNoiseReport();
            MedianNoiseExtractor medianNoiseExtractor;
            medianNoiseExtractor = new MedianNoiseExtractor(sourceFile);
            ImageIO.write(medianNoiseExtractor.displaySurface, "png", outputFile);
            ByteArrayOutputStream medianNoisebytes = new ByteArrayOutputStream();
            ImageIO.write(medianNoiseExtractor.displaySurface, "png", medianNoisebytes);

            medianNoiseReport.map = outputFile.getCanonicalPath();
            medianNoiseReport.completed=true;
            return medianNoiseReport;
        }
    }

    private static class GridsThread implements Callable {
        String sourceFile ="";
        File outputFileGI =null;
        File outputFileG= null;
        public GridsThread(String sourceFile,File outputFileG, File outputFileGI){
            this.sourceFile =sourceFile;
            this.outputFileG = outputFileG;
            this.outputFileGI = outputFileGI;
        }
        @Override
        public GridsBothReport call() {
            GridsBothReport output=null;
            try {
                output= gridsCalculation();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return output;
        }
        public GridsBothReport gridsCalculation() throws IOException {
            GridsBothReport gridsBothReport =new GridsBothReport();
            GridsExtractor gridsExtractor;
            gridsExtractor = new GridsExtractor(sourceFile);
            ImageIO.write(gridsExtractor.displaySurfaceG, "png", outputFileG);
            ByteArrayOutputStream gridsbytes = new ByteArrayOutputStream();
            ImageIO.write(gridsExtractor.displaySurfaceG, "png", gridsbytes);

            ImageIO.write(gridsExtractor.displaySurfaceGI, "png", outputFileGI);
            ByteArrayOutputStream gridsInvbytes = new ByteArrayOutputStream();
            ImageIO.write(gridsExtractor.displaySurfaceGI, "png", gridsInvbytes);

            gridsBothReport.mapG = outputFileG.getCanonicalPath();
            gridsBothReport.mapGI = outputFileGI.getCanonicalPath();
            gridsBothReport.maxValueG = gridsExtractor.gridsmaxG;
            gridsBothReport.minValueG = gridsExtractor.gridsminG;
            gridsBothReport.maxValueG = gridsExtractor.gridsmaxGI;
            gridsBothReport.minValueG = gridsExtractor.gridsminGI;
            gridsBothReport.completed=true;

            gridsBothReport.gridsNormalReport.map=outputFileG.getCanonicalPath();
            gridsBothReport.gridsNormalReport.maxValue = gridsExtractor.gridsmaxG;
            gridsBothReport.gridsNormalReport.minValue = gridsExtractor.gridsminG;
            gridsBothReport.gridsNormalReport.completed=true;

            gridsBothReport.gridsInversedReport.map=outputFileGI.getCanonicalPath();
            gridsBothReport.gridsInversedReport.maxValue = gridsExtractor.gridsmaxGI;
            gridsBothReport.gridsInversedReport.minValue = gridsExtractor.gridsminGI;
            gridsBothReport.gridsInversedReport.completed=true;
            return gridsBothReport;
        }
    }


    public static void main (String[] args) throws IOException {

        if (args.length == 1){
            url = args[0];
        }else{
            System.out.println("Wrong number of arguments");
            url ="http://160.40.50.109:8080/example6_big.jpg";
        }
        // String OutputFolder = "/home/marzampoglou/Pictures/Reveal/ManipulationOutput/";
        // String Hash1=downloadURL("http://160.40.51.26/projects/Reveal/imgs/example6_big.jpg", OutputFolder, "127.0.0.1");
        // String OutputFolder = "D:\\Reveal\\image-forensics-local-data\\ManipulationOutput\\";
        // String Hash1=downloadURL(url, OutputFolder, "127.0.0.1");
        //System.out.println("OutputFolder " + OutputFolder);
        //System.out.println("Hash1 " + Hash1);
        //  createReport(Hash1, "127.0.0.1", OutputFolder);
    }

    public static String getMeta(String path) {
        // Get the metadata from a local file
        // This code is used in certain side projects
        // and is not part of the main REVEAL functionalities
        String Hash1;

        MetadataExtractor metaExtractor;
        String metadataStringReport = "";
        try {
            metaExtractor = new MetadataExtractor(path);
            JsonObject metadataReport = metaExtractor.metadataReport;
            metadataReport.addProperty("completed", true);
            metadataStringReport = metadataReport.toString();

        } catch (IOException e) {
            e.printStackTrace();
        } catch (ImageProcessingException e) {
            e.printStackTrace();
        }
        return metadataStringReport;
    }
}

/*
package gr.iti.mklab.reveal.web;

import com.mongodb.MongoClientURI;
import gr.iti.mklab.reveal.forensics.api.ForensicReport;
import gr.iti.mklab.reveal.forensics.api.ForensicReportBase64;
import gr.iti.mklab.reveal.forensics.api.ReportManagement;

import gr.iti.mklab.reveal.util.Configuration;

import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;
import javax.annotation.PreDestroy;


@Controller
@RequestMapping("/")
public class RevealControllerA {

    public RevealControllerA() throws Exception {
        Configuration.load(getClass().getResourceAsStream("/local.properties"));
    }

    @PreDestroy
    public void cleanUp() throws Exception {
        System.out.println("Spring Container destroy");
    }

    @RequestMapping(value = "/addurl", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public String addverification(@RequestParam(value = "url", required = true) String url) throws RevealException {
        try {
            System.out.println("Received new URL. Downloading...");
            MongoClientURI mongoURI = new MongoClientURI(Configuration.MONGO_URI);
            String URL=ReportManagement.downloadURL(url, Configuration.MANIPULATION_REPORT_PATH, mongoURI );
            return URL;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/generatereport", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public String generateReport(@RequestParam(value = "hash", required = true) String hash) throws RevealException {
        try {
            System.out.println("Received new hash for analysis. Beginning...");
            MongoClientURI mongoURI = new MongoClientURI(Configuration.MONGO_URI);
            String ReportResult=ReportManagement.createReport(hash, mongoURI, Configuration.MANIPULATION_REPORT_PATH,Configuration.MAX_GHOST_IMAGE_SMALL_DIM,Configuration.NUM_GHOST_THREADS,Configuration.NUM_TOTAL_THREADS,Configuration.FORENSIC_PROCESS_TIMEOUT);
            System.out.println("Analysis complete with message: " + ReportResult);
            return ReportResult;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/getreport", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public ForensicReport returnReport(@RequestParam(value = "hash", required = true) String hash) throws RevealException {
        try {
            System.out.println("Request for forensic report received, hash=" + hash + ".");
            MongoClientURI mongoURI = new MongoClientURI(Configuration.MONGO_URI);
            ForensicReport Report=ReportManagement.getReport(hash, mongoURI);
            if (Report!=null) {
                if (Report.elaReport.completed)
                    Report.elaReport.map=Report.elaReport.map.replace(Configuration.MANIPULATION_REPORT_PATH, Configuration.HTTP_HOST + "images/");
                if (Report.dqReport.completed)
                    Report.dqReport.map=Report.dqReport.map.replace(Configuration.MANIPULATION_REPORT_PATH,Configuration.HTTP_HOST + "images/");
                if (Report.displayImage!=null)
                    Report.displayImage=Report.displayImage.replace(Configuration.MANIPULATION_REPORT_PATH,Configuration.HTTP_HOST + "images/");
                if (Report.dwNoiseReport.completed)
                    Report.dwNoiseReport.map=Report.dwNoiseReport.map.replace(Configuration.MANIPULATION_REPORT_PATH,Configuration.HTTP_HOST + "images/");
                if (Report.gridsReport.completed){
                    Report.gridsReport.map=Report.gridsReport.map.replace(Configuration.MANIPULATION_REPORT_PATH,Configuration.HTTP_HOST + "images/");
                }
                if (Report.gridsInversedReport.completed){
                    Report.gridsInversedReport.map=Report.gridsInversedReport.map.replace(Configuration.MANIPULATION_REPORT_PATH,Configuration.HTTP_HOST + "images/");
                }
                if (Report.ghostReport.completed) {
                    for (int GhostInd = 0; GhostInd < Report.ghostReport.maps.size(); GhostInd++) {
                        Report.ghostReport.maps.set(GhostInd, Report.ghostReport.maps.get(GhostInd).replace(Configuration.MANIPULATION_REPORT_PATH, Configuration.HTTP_HOST + "images/"));
                    }
                }
                if (Report.thumbnailReport.numberOfThumbnails>0) {
                    for (int ThumbInd = 0; ThumbInd < Report.thumbnailReport.thumbnailList.size(); ThumbInd++) {
                        Report.thumbnailReport.thumbnailList.set(ThumbInd, Report.thumbnailReport.thumbnailList.get(ThumbInd).replace(Configuration.MANIPULATION_REPORT_PATH, Configuration.HTTP_HOST + "images/"));
                    }
                }
                if (Report.blockingReport.completed)
                    Report.blockingReport.map=Report.blockingReport.map.replace(Configuration.MANIPULATION_REPORT_PATH,Configuration.HTTP_HOST + "images/");
                if (Report.medianNoiseReport.completed)
                    Report.medianNoiseReport.map=Report.medianNoiseReport.map.replace(Configuration.MANIPULATION_REPORT_PATH,Configuration.HTTP_HOST + "images/");

            }
            return Report;

        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }


    @RequestMapping(value = "/getreportbase64", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public ForensicReportBase64 returnReportBase64(@RequestParam(value = "hash", required = true) String hash) throws RevealException {
        try {
            System.out.println("Request for base64 forensic report received, hash=" + hash + ".");
            MongoClientURI mongoURI = new MongoClientURI(Configuration.MONGO_URI);
            ForensicReportBase64 Report=ReportManagement.getBase64(hash, mongoURI);

            return Report;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @ResponseStatus(value = HttpStatus.INTERNAL_SERVER_ERROR)
    @ExceptionHandler(RevealException.class)
    @ResponseBody
    public RevealException handleCustomException(RevealException ex) {
        return ex;
    }

    public static void main(String[] args) throws Exception {

    }
}
*/
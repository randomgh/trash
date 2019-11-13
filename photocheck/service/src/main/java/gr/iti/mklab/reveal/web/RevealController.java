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

import gr.iti.mklab.reveal.forensics.api.reports.*;

@Controller
@RequestMapping("/")
public class RevealController {

    public RevealController() throws Exception {
        Configuration.load(getClass().getResourceAsStream("/remote.properties"));
    }

    @PreDestroy
    public void cleanUp() throws Exception {
        System.out.println("Spring Container destroy");
    }

    @RequestMapping(value = "/source", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public SourceReport source(@RequestParam(value = "request", required = true) String request, @RequestParam(value = "file_id", required = true) String file_id, @RequestParam(value = "file_name", required = true) String file_name, @RequestParam(value = "mime", required = true) String mime) throws RevealException {
        System.out.println("source: " + request + " " + file_id + " " + file_name + " " + mime + " ");
        try {
            SourceReport report = ReportManagement.source(request, file_id, file_name, mime, Configuration.MANIPULATION_REPORT_PATH);
        System.out.println("source: done");
            return report;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/dq", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public dqReport dq(@RequestParam(value = "request", required = true) String request, @RequestParam(value = "file_id", required = true) String file_id, @RequestParam(value = "file_name", required = true) String file_name, @RequestParam(value = "mime", required = true) String mime) throws RevealException {
        try {
            dqReport report = ReportManagement.dq(request, file_id, file_name, mime, Configuration.MANIPULATION_REPORT_PATH);
            return report;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/ela", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public ELAReport ela(@RequestParam(value = "request", required = true) String request, @RequestParam(value = "file_id", required = true) String file_id, @RequestParam(value = "file_name", required = true) String file_name, @RequestParam(value = "mime", required = true) String mime) throws RevealException {
        try {
            ELAReport report = ReportManagement.ela(request, file_id, file_name, mime, Configuration.MANIPULATION_REPORT_PATH);
            return report;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/blocking", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public BlockingReport blocking(@RequestParam(value = "request", required = true) String request, @RequestParam(value = "file_id", required = true) String file_id, @RequestParam(value = "file_name", required = true) String file_name, @RequestParam(value = "mime", required = true) String mime) throws RevealException {
        try {
            BlockingReport report = ReportManagement.blocking(request, file_id, file_name, mime, Configuration.MANIPULATION_REPORT_PATH);
            return report;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/ghost", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public GhostReport ghost(@RequestParam(value = "request", required = true) String request, @RequestParam(value = "file_id", required = true) String file_id, @RequestParam(value = "file_name", required = true) String file_name, @RequestParam(value = "mime", required = true) String mime) throws RevealException {
        try {
            GhostReport report = ReportManagement.ghost(request, file_id, file_name, mime, Configuration.MANIPULATION_REPORT_PATH);
            return report;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/dwNoise", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public DWNoiseReport dwNoise(@RequestParam(value = "request", required = true) String request, @RequestParam(value = "file_id", required = true) String file_id, @RequestParam(value = "file_name", required = true) String file_name, @RequestParam(value = "mime", required = true) String mime) throws RevealException {
        try {
            DWNoiseReport report = ReportManagement.dwNoise(request, file_id, file_name, mime, Configuration.MANIPULATION_REPORT_PATH);
            return report;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/medianNoise", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public MedianNoiseReport medianNoise(@RequestParam(value = "request", required = true) String request, @RequestParam(value = "file_id", required = true) String file_id, @RequestParam(value = "file_name", required = true) String file_name, @RequestParam(value = "mime", required = true) String mime) throws RevealException {
        try {
            MedianNoiseReport report = ReportManagement.medianNoise(request, file_id, file_name, mime, Configuration.MANIPULATION_REPORT_PATH);
            return report;
        } catch (Exception ex) {
            throw new RevealException((ex.getMessage()), ex);
        }
    }

    @RequestMapping(value = "/grids", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public GridsReport grids(@RequestParam(value = "request", required = true) String request, @RequestParam(value = "file_id", required = true) String file_id, @RequestParam(value = "file_name", required = true) String file_name, @RequestParam(value = "mime", required = true) String mime) throws RevealException {
        try {
            GridsReport report = ReportManagement.grids(request, file_id, file_name, mime, Configuration.MANIPULATION_REPORT_PATH);
            return report;
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
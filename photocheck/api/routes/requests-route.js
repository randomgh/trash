import { Router } from 'express';
import multer from 'multer';
import os from 'os';
import dotenv from 'dotenv';

import { requests } from '../controllers';

dotenv.config();

const router = new Router(),
      uploads = multer({
          dest: process.env.UPLOADS_DIR ? process.env.UPLOADS_DIR : os.tmpdir(),
          fileFilter: (req, file, cb) => {
              cb(null, ['image/jpeg', 'image/png'].includes(file.mimetype));
          }
      });

router.get('[/]?', requests.getAll);
router.post('[/]?', uploads.array('images'), requests.create);

router.get('/:_id[/]?', requests.getOne);
router.delete('/:_id[/]?', requests.delete);

export default router;
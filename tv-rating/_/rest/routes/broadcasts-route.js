import { Router } from 'express';
import multer from 'multer';
import path from 'path';
import dotenv from 'dotenv';

import { broadcasts } from '../controllers';

dotenv.config();

const router = new Router(),
      upload = multer({ dest: path.resolve(__dirname, `../..${process.env.UPLOADS_DIR}/broadcasts`) });

router.post('/', upload.single('image'), broadcasts.create);
router.get('/', broadcasts.getAll);
router.put('/', upload.single('image'), broadcasts.update);
router.delete('/', broadcasts.delete);

router.get('/:_id', broadcasts.getOne);
router.put('/:_id', upload.single('image'), broadcasts.update);
router.delete('/:_id', broadcasts.delete);

export default router;
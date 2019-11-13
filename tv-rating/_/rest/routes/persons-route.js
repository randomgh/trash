import { Router } from 'express';
import multer from 'multer';
import path from 'path';
import dotenv from 'dotenv';

import { persons } from '../controllers';

dotenv.config();

const router = new Router(),
      upload = multer({ dest: path.resolve(__dirname, `../..${process.env.UPLOADS_DIR}/persons`) });

router.post('/', upload.single('image'), persons.create);
router.get('/', persons.getAll);
router.put('/', upload.single('image'), persons.update);
router.delete('/', persons.delete);

router.get('/:_id', persons.getOne);
router.put('/:_id', upload.single('image'), persons.update);
router.delete('/:_id', persons.delete);

export default router;
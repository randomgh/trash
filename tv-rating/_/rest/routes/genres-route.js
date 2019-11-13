import { Router } from 'express';
import multer from 'multer';
import path from 'path';
import dotenv from 'dotenv';

import { genres } from '../controllers';

dotenv.config();

const router = new Router(),
      upload = multer({ dest: path.resolve(__dirname, `../..${process.env.UPLOADS_DIR}/genres`) });

router.post('/', upload.single('image'), genres.create);
router.get('/', genres.getAll);
router.put('/', upload.single('image'), genres.update);
router.delete('/', genres.delete);

router.get('/:_id', genres.getOne);
router.put('/:_id', upload.single('image'), genres.update);
router.delete('/:_id', genres.delete);

export default router;
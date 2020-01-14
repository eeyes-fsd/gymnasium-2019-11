/*
 * Academic License - for use in teaching, academic research, and meeting
 * course requirements at degree granting institutions only.  Not for
 * government, commercial, or other organizational use.
 *
 * indefinite_solve.h
 *
 * Code generation for function 'indefinite_solve'
 *
 */

#ifndef INDEFINITE_SOLVE_H
#define INDEFINITE_SOLVE_H

/* Include files */
#include <stddef.h>
#include <stdlib.h>
#include "rtwtypes.h"
#include "indefinite_solve_types.h"

/* Function Declarations */
extern void indefinite_solve(const emxArray_real_T *aeq, const double beq[3],
  const emxArray_real_T *lb, emxArray_real_T *answer);

#endif

/* End of code generation (indefinite_solve.h) */

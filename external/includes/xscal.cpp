/*
 * Academic License - for use in teaching, academic research, and meeting
 * course requirements at degree granting institutions only.  Not for
 * government, commercial, or other organizational use.
 *
 * xscal.cpp
 *
 * Code generation for function 'xscal'
 *
 */

/* Include files */
#include "rt_nonfinite.h"
#include "indefinite_solve.h"
#include "xscal.h"

/* Function Definitions */
void b_xscal(double a, double x_data[], int ix0)
{
  int k;
  for (k = ix0; k <= ix0 + 2; k++) {
    x_data[k - 1] *= a;
  }
}

void c_xscal(int n, double a, emxArray_real_T *x, int ix0)
{
  int i4;
  int k;
  i4 = (ix0 + n) - 1;
  for (k = ix0; k <= i4; k++) {
    x->data[k - 1] *= a;
  }
}

void xscal(int n, double a, emxArray_real_T *x, int ix0)
{
  int i3;
  int k;
  i3 = (ix0 + n) - 1;
  for (k = ix0; k <= i3; k++) {
    x->data[k - 1] *= a;
  }
}

/* End of code generation (xscal.cpp) */
